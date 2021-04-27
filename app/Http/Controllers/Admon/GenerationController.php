<?php

namespace App\Http\Controllers\Admon;

use App\Account;
use App\Debt;
use App\Diplomat;
use App\Generation;
use App\Http\Requests\StoreGeneration;
use App\Low;
use App\Student;
use App\StudentInscription;
use App\Teacher;
use App\Payment;
use App\PaymentReceived;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;
use PDF;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\PagoDocente;
use App\PagoRecibidoDiplomado;
use App\PaymentMethod;
use App\User;
use Carbon\Carbon;

class GenerationController extends Controller
{
    public function index(Request $request)
    {
        $diplomats = Diplomat::orderBy('name')->get();
        $docents = Teacher::orderBy('name')->get();
        return view('admon.generations.index', compact('diplomats', 'docents'));
    }

    public function findStudent(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $students = Student::select('name', 'last_name', 'mother_last_name')
            ->where('name', 'like', '%' . $term . '%')
            ->orderBy('name', 'desc')->get();

        $formatted_tags = [];

        foreach ($students as $student) {
            $formatted_tags[] = ['id' => $student->id, 'text' => $student->name];
        }

        return \Response::json($formatted_tags);
    }


    public function dataGenerations()
    {

        $generations = Generation::select([
            'id', 'name_diplomat', 'docent', 'number_generation', 'number_students',
            'cost', 'maximum_cost', 'commision', 'full_price', 'created_at'
        ])->orderBy('name_diplomat');

        return Datatables::of($generations)
            ->addColumn('total_inscriptions', function ($generation) {
                $data = StudentInscription::where('generation_id', '=', $generation->id)->count();

                return $data;
            })

            ->addColumn('action', function ($generation) {
                $id = $generation->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <a href="/admon/generaciones/alumnos/inscritos/' . $id . '" class="btn btn-rounded btn-xs btn-info mb-3"><i class="fa fa-eye"></i> Detalles</a>
                <button class="btn btn-rounded btn-xs btn-primary mb-3" value="' . $id . '" OnClick="Show(this);" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" OnClick="DeleteMod(' . $id . ');" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i> Eliminar</button>
                </div></td>';
            })
            ->make(true);
    }

    public function listStudentsGeneration($id)
    {
        $generation = Generation::find($id);
        $metodos = PaymentMethod::all();
        $cuentas = Account::all();

        $estudiantes = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('diplomats', 'student_inscriptions.diplomat_id', '=', 'diplomats.id')
            ->join('generations', 'student_inscriptions.generation_id', '=', 'generations.id')
            ->leftJoin('debts', 'debts.generation_id', '=', 'student_inscriptions.id')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->where('student_inscriptions.status', '=', 'Alta')
            ->select(
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as estudiante'),
                'students.email as email',
                'students.enrollment as matricula',
                DB::raw('CONCAT(diplomats.key, generations.start_date, students.enrollment) AS folio'),
                'students.curp',
                'students.phone as phone',
                DB::raw('CONCAT(student_inscriptions.number_of_payments," PAGOS DE ",student_inscriptions.amount_of_payments) as observations'),
                'student_inscriptions.discount as descuento',
                'student_inscriptions.first_payment as primer_pago',
                'student_inscriptions.id as ID',
                'student_inscriptions.final_cost as costo_final',
                'student_inscriptions.status as status',
                'debts.amount as debe',
                'debts.id as debt_id'
            )
            ->get();

        return view('admon.generations.estudiantes-inscritos', compact('estudiantes','generation', 'metodos', 'cuentas'));
    }

    public function dataStudents($id)
    {
        $inscription = StudentInscription::find($id);
        $student = Student::where('id', '=', $inscription->student_id)->first();
        $debt = Debt::where('generation_id', '=', $inscription->id)->first();
        $vendedor = User::where('id', '=', $student->user_id)->first();
        $payments = Payment::where('debt_id', '=', $debt->id)->get();
        $diplomado = Diplomat::where('id', '=', $inscription->diplomat_id)->first();
        $generacion = Generation::where('id', '=', $inscription->generation_id)->first();

        return response()->json([
            'inscripcion' => $inscription,
            'estudiante' => $student,
            'diplomado' => $diplomado,
            'vendedor' => $vendedor,
            'generacion' => $generacion,
            'deuda' => $debt,
            'pagos' => $payments
        ]);
    }

    public function newPayment(Request $request)
    {
        $fecha = Carbon::now()->toDateString();

        $inscripcion = StudentInscription::find($request->id_inscripcion);
        $deuda = Debt::where('generation_id', '=', $request->id_inscripcion)->first();

        $ultimo_pago = Payment::where('debt_id', '=', $deuda->id)->latest('id')->first();

        $nuevo_pago = new Payment();
        $nuevo_pago->concept = 'COLEGIATURA';
        $nuevo_pago->number_payment = $ultimo_pago->number_payment + 1;
        $nuevo_pago->date = $fecha;
        $nuevo_pago->amount_paid = 0;
        $nuevo_pago->student_id = $inscripcion->student_id;
        $nuevo_pago->generation_id = $inscripcion->generation_id;
        $nuevo_pago->diplomat_id = $inscripcion->diplomat_id;
        $nuevo_pago->status = 'PENDIENTE';
        $nuevo_pago->debt_id = $deuda->id;
        $nuevo_pago->save();

        return response()->json($inscripcion);
    }

    function storePayment(Request $request)
    {
        try {
            $pago = Payment::findOrFail($request->id_pago);
            $deuda = Debt::where('id', '=', $pago->debt_id)->first();
            $inscripcion = StudentInscription::where('id', '=', $deuda->generation_id)->first();

            $pago_recibido = new PagoRecibidoDiplomado();
            $pago_recibido->numero_de_pago = $pago->number_payment;
            $pago_recibido->fecha_pago = $request->fecha_pago;
            $pago_recibido->monto_recibido = $request->monto;
            $pago_recibido->metodo_de_pago = $request->metodo_pago;
            $pago_recibido->cuenta_destino = $request->cuenta_destino;
            $pago_recibido->inscripcion_id = $inscripcion->id;
            $pago_recibido->deuda_id = $deuda->id;
            $pago_recibido->generacion_id = $inscripcion->generation_id;
            $pago_recibido->student_id = $inscripcion->student_id;
            $pago_recibido->save();

            $pago->status = 'PAGADO';
            $pago->save();

            $deuda->amount = $deuda->amount - $pago_recibido->monto_recibido;
            $deuda->save();

            if ($deuda->amount <= 0) {
                $deuda->status = 'PAGADA';
                $deuda->save();

                $pagos_pendientes = Payment::where('debt_id', '=', $deuda->id)
                    ->where('status', '=', 'PENDIENTE')
                    ->get();

                if ($pagos_pendientes) {
                    foreach ($pagos_pendientes as $key => $pago) {
                        $pago->status = 'PAGADO';
                        $pago->save();
                    }
                }
            }

            return response()->json([
                'i' => $inscripcion,
                'd' => $deuda,
                'p' => $pago,
                'pr' => $pago_recibido
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function dataDocent($id)
    {
        $generacion = Generation::find($id);
        $diplomado = Diplomat::where('id', '=', $generacion->diplomat_id)->first();
        $esquema = PagoDocente::where('generacion_id', '=', $generacion->id)->first();
        $docente = Teacher::where('id', '=', $esquema->docente_id)->first();
        

        return response()->json([
            'g' => $generacion,
            'd' => $diplomado,
            'e' => $esquema,
            'dc' => $docente
        ]);
    }

    public function studentsInscription($id)
    {
        $students = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('diplomats', 'student_inscriptions.diplomat_id', '=', 'diplomats.id')
            ->join('generations', 'student_inscriptions.generation_id', '=', 'generations.id')
            ->leftJoin('debts', 'debts.generation_id', '=', 'student_inscriptions.id')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->where('student_inscriptions.status', '=', 'Alta')
            ->select(
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as full_name'),
                'students.email as email',
                'students.enrollment',
                DB::raw('CONCAT(diplomats.key, generations.start_date, students.enrollment) AS folio'),
                'students.curp',
                'students.phone as phone',
                'students.documents as documents',
                DB::raw('CONCAT(student_inscriptions.number_of_payments," PAGOS DE ",student_inscriptions.amount_of_payments) as observations'),
                'student_inscriptions.discount as discount',
                'student_inscriptions.first_payment as first_payment',
                'student_inscriptions.id as id_inscription',
                'student_inscriptions.final_cost as final_cost',
                'student_inscriptions.status as status',
                'debts.amount as total_debt',
                'debts.id as debt_id'
            )
            ->get();

        return Datatables::of($students)
            ->addColumn('payments', function ($student) {
                $id = $student->id_inscription;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="showPayments(' . $id . ');" class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal" data-target="#modalListPayments"><i class="fa fa-edit"></i>Pagos</button></div></td>';
            })
            ->addColumn('action', function ($student) {
                $id = $student->id_inscription;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" OnClick="DeleteMod(' . $id . ');" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->rawColumns(['payments', 'action'])
            ->make(true);
    }

    public function recentsInscription()
    {
        $recents = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('diplomats', 'student_inscriptions.diplomat_id', '=', 'diplomats.id')
            ->join('generations', 'student_inscriptions.generation_id', '=', 'generations.id')
            ->where('student_inscriptions.read', '=', 0)
            ->select(
                'student_inscriptions.id as id',
                'generations.number_generation as generation',
                'diplomats.name as name_diplomat',
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as full_name'),
                'students.enrollment',
                'students.curp',
                'student_inscriptions.created_at as date',
                'student_inscriptions.id as id_inscription'
            )
            ->get();

        return Datatables::of($recents)
            ->addColumn('action', function ($recent) {
                $id = $recent->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <button value="' . $id . '" OnClick="ShowInscriptionRecent(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalInscriptionRecent"><i class="fa fa-search"></i> Detalles</button>
                <button value="' . $id . '" OnClick="markRead(this);" class="btn btn-rounded btn-xs btn-success mb-3"><i class="fa fa-check"></i> Marcar como procesada</button>
                <button value="' . $id . '" OnClick="sendVoucher(this);" class="btn btn-rounded btn-xs btn-dark mb-3"><i class="fa fa-envelope"></i> Enviar recibo</button>
                </td>';
            })
            ->make(true);
    }

    public function consult($id)
    {
        $data = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('diplomats', 'student_inscriptions.diplomat_id', '=', 'diplomats.id')
            ->join('generations', 'student_inscriptions.generation_id', '=', 'generations.id')
            ->where('student_inscriptions.id', '=', $id)
            ->select(
                'student_inscriptions.id as id',
                'generations.number_generation as generation',
                'diplomats.name as name_diplomat',
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as full_name'),
                'students.enrollment',
                'students.curp',
                'student_inscriptions.created_at as date',
                'student_inscriptions.id as id_inscription',
                'student_inscriptions.discount as discount',
                'student_inscriptions.final_cost as final_cost',
                'student_inscriptions.number_of_payments as number_of_payments',
                'student_inscriptions.first_payment as payment'
            )
            ->first();

        return response()->json($data);
    }

    public function read(Request $request, $id)
    {
        $data = StudentInscription::find($id);
        $data->read = 1;
        $data->save();
        return response()->json(["message" => "success"]);
    }

    public function sendVoucher($id)
    {
        $info = ['info' => 'test'];

        Mail::send(['text' => 'mail'], $info, function ($message) {
            $id = Input::get('id');
            $inscription = StudentInscription::find($id);
            $debt = Debt::where('generation_id', '=', $id)->first();
            $student = Student::find($inscription->student_id);
            $data = DB::table('payment_receiveds')->where([
                ['debt_id', '=', $debt->id],
                ['type', '=', '0'],
            ])->first();

            //$pdf = PDF::loadView('pdf.voucher');
            $pdf = PDF::loadView('payments.voucher', compact('data'))->setPaper('a4', 'landscape');
            $message->to($student->email, 'Estudiante')->subject('Comprobante de pago | SERendipity');
            $message->from('serendipity@gmail.com', 'Administración');
            $message->attachData($pdf->output(), 'comprobante.pdf');
        });

        return response()->json(["message" => "success"]);
    }

    public function sendVoucherTwo($id)
    {
        $info = ['info' => 'test'];

        Mail::send(['text' => 'mail'], $info, function ($message) {
            $id = Input::get('id');

            $data = DB::table('payment_receiveds')->where([
                ['id', '=', $id],
            ])->first();

            $student = Student::find($data->student_id);

            //$pdf = PDF::loadView('pdf.voucher');
            $pdf = PDF::loadView('payments.voucher', compact('data'))->setPaper('a4', 'landscape');
            $message->to($student->email, 'Estudiante')->subject('Comprobante de pago | SERendipity');
            $message->from('serendipity@gmail.com', 'Administración');
            $message->attachData($pdf->output(), 'comprobante.pdf');
        });

        return response()->json(["message" => "success"]);
    }

    public function search($id)
    {
        $data = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('debts', 'debts.generation_id', '=', 'student_inscriptions.id')
            ->where('student_inscriptions.id', '=', $id)
            ->select(
                DB::raw('CONCAT(students.name, " ", students.last_name, " ", students.mother_last_name) AS fullname'),
                'student_inscriptions.discount as discount',
                'student_inscriptions.final_cost as final_cost',
                'student_inscriptions.first_payment as first_payment',
                'debts.amount as debt',
                'debts.id as debt_id',
                'student_inscriptions.created_at as date',
                'student_inscriptions.id as id_inscription'
            )
            ->first();

        //$payments = PaymentReceived::where('debt_id', '=', $data->debt_id)->get();

        return response()->json($data);
    }

    public function students($id)
    {
        $students = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('debts', 'students.id', '=', 'debts.student_id')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->select('students.name as name', 'students.last_name as last_name', 'students.mother_last_name as mother_last_name', 'debts.amount as debt')
            ->get();

        return Datatables::of($students)
            ->make(true);
    }

    public function store(StoreGeneration $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            $diplomat = Diplomat::find($request->name_diplomat);
            $docent = Teacher::find($request->docent_id);

            if ($this->checkNumber($request->number_generation, $diplomat->id)) {
                return response()
                    ->json([
                        'message' => 'Ya existe un registro de este diploma con el mismo número de generación.',
                        'status' => 400,
                    ], 400);
            } else {
                $generation = new Generation();
                $generation->name_diplomat = $diplomat->name;
                $generation->number_generation = $request->number_generation;
                $generation->cost = $request->cost;
                $generation->maximum_cost = $request->maximum_cost;
                $generation->start_date = $request->start_date;
                $generation->commision = $request->commision;
                $generation->full_price = $request->full_price;
                $generation->status = $request->status;
                $generation->docent = $docent->name . ' ' . $docent->last_name . ' ' . $docent->mother_last_name;
                $generation->docent_id = $docent->id;
                $generation->diplomat_id = $diplomat->id;
                $generation->save();
            }

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function checkNumber($number, $diplomat)
    {
        $query = DB::table('generations')
            ->where('diplomat_id', '=', $diplomat)
            ->where('number_generation', '=', $number)
            ->first();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id)
    {
        $generation = Generation::find($id);
        return response()->json($generation);
    }

    public function update(Request $request, $id)
    {
        $generation = Generation::find($id);
        $generation->fill($request->all());
        $generation->save();

        $docent = Teacher::where('id', '=', $request->docent_id)->first();
        $generation->docent = $docent->name . ' ' . $docent->last_name . ' ' . $docent->mother_last_name;
        $generation->save();

        return response()->json(["message" => "success"]);
    }

    public function deleteStudent($id)
    {
        try {
            DB::beginTransaction();
            $ins = StudentInscription::where('id', '=', $id)->first();

            $debt = Debt::where('generation_id', '=', $ins->id)->first();

            $payments = DB::table('payments')
                ->where('debt_id', '=', $debt->id)->delete();

            $payment_receiveds = DB::table('payment_receiveds')
                ->where('debt_id', '=', $debt->id)->delete();

            $agreements = DB::table('agreements')
                ->join('debts', 'agreements.debt_id', '=', 'debts.id')
                ->where('debts.id', '=', $debt->id)->delete();

            $debt->delete();

            $ins->delete();
            DB::commit();

            return response()->json([
                'success' => 'Record has been deleted successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $generation = Generation::find($request->id);
            $inscriptions = StudentInscription::where('generation_id', '=', $generation->id)->get();

            foreach ($inscriptions as $key => $value) {

                $ins = StudentInscription::where('generation_id', '=', $generation->id)->first();

                $debt = Debt::where('generation_id', '=', $ins->id)->first();

                $payments = DB::table('payments')
                    ->where('debt_id', '=', $debt->id)->delete();

                $payment_receiveds = DB::table('payment_receiveds')
                    ->where('debt_id', '=', $debt->id)->delete();

                $agreements = DB::table('agreements')
                    ->join('debts', 'agreements.debt_id', '=', 'debts.id')
                    ->where('debts.id', '=', $debt->id)->delete();

                $debt->delete();

                $ins->delete();
            }

            $generation->delete();

            DB::commit();

            return response()->json([
                'success' => 'Record has been deleted successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function down($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $debt = Debt::where('generation_id', '=', $id)->first();

            $inscription = StudentInscription::find($id);
            $inscription->status = 'Baja';
            $inscription->save();

            if ($inscription) {
                $debt->status = 'BAJA';
                $debt->save();

                $low = new Low();
                $low->reason = $request->reason;
                $low->comments = $request->comments;
                $low->studentinscriptions_id = $inscription->id;
                $low->save();
            }

            DB::commit();

            return response()->json([
                'success' => 'Record has been deleted successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function discount(Request $request)
    {
        try {
            DB::beginTransaction();

            $debt = Debt::where('generation_id', '=', $request->id)->first();
            $debt->amount -= $request->amount;
            $debt->save();

            DB::commit();

            return response()->json([
                'success' => 'Record has been updated successfully!',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function up($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $debt = Debt::where('generation_id', '=', $id)->first();

            $inscription = StudentInscription::find($id);
            $inscription->status = 'Alta';
            $inscription->save();

            if ($inscription) {
                $debt->status = 'ACTIVA';
                $debt->save();

                $low = Low::where('studentinscriptions_id', '=', $inscription->id)->first();
                $low->delete();
            }
            DB::commit();

            return response()->json([
                'success' => 'Record has been deleted successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function low($id)
    {
        $low = Low::where('studentinscriptions_id', '=', $id)->first();
        return response()->json($low);
    }

    public function editPay(Request $request)
    {
        try {
            $debt = Debt::find($request->debt_id);
            $inscription = StudentInscription::where('id', '=', $debt->generation_id)->first();

            $original = $inscription->first_payment;
            $new = $request->amount_pay;

            $debtA = Debt::where('generation_id', '=', $inscription->id)->first();

            $debtA->amount = $debtA->amount + $original;
            $debtA->amount = $debtA->amount - $new;
            $debtA->save();

            $inscription->first_payment = $new;
            $inscription->save();

            return response()->json(["message" => "success"]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function editPayTwo(Request $request)
    {
        try {
            $debt = Debt::find($request->debt_id);

            $payment = Payment::where('debt_id', '=', $debt->id)
                ->where('number_payment', '=', $request->num_pay)->first();

            $payment_received = PaymentReceived::where('debt_id', '=', $debt->id)
                ->where('number_pay', '=', $request->num_pay)->first();

            $debt->amount = $debt->amount + $payment_received->amount;
            $debt->save();

            $payment_received->amount = $request->amount_pay;
            $payment_received->total = $request->amount_pay;
            $payment_received->save();

            $payment->amount_paid = $payment_received->amount;
            $payment->save();

            $debt->amount = $debt->amount - $payment_received->amount;
            $debt->save();

            return response()->json([
                "message" => "success",
                "debt" => $debt,
                "payment" => $payment,
                "payment_received" => $payment_received
            ]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    // news functions for payments
    public function getDataPayments($id)
    {
        $inscription = StudentInscription::find($id);
        $debt = Debt::where('generation_id', '=', $inscription->id)->first();
        $payments = Payment::where('debt_id', '=', $debt->id)->get();
        return response()->json([
            'inscription' => $inscription,
            'debt' => $debt,
            'payments' => $payments
        ]);
    }

    public function getDataPaymentGeneral($id)
    {
        $inscription = StudentInscription::find($id);
        $debt = Debt::where('generation_id', '=', $inscription->id)->first();
        $payments = Payment::where('debt_id', '=', $debt->id)->get();
        return response()->json([
            'inscription' => $inscription,
            'debt' => $debt,
            'payments' => $payments
        ]);
    }

    public function getPayments($id)
    {
        $inscription = StudentInscription::find($id);
        $debt = Debt::where('generation_id', '=', $inscription->id)->first();
        $payments = Payment::where('debt_id', '=', $debt->id)->get();

        return Datatables::of($payments)
            ->addColumn('description', function ($payment) {
                return 'Pago número ' . $payment->number_payment;
            })
            ->addColumn('payment', function ($payment) {
                $id = $payment->id;
                if ($payment->status != 'PAGADO') {
                    return '<td><div class="btn-group" role="group"><a href="#" value="' . $id . '" OnClick="applyPayment(' . $id . ');" class="btn btn-rounded btn-xs btn-success mb-3"><i class="fa fa-edit"></i>Pagar</a></div></td>';
                } else {
                    return 'Pago aplicado';
                }
            })
            ->addColumn('agreement', function ($payment) {
                $id = $payment->id;
                if ($payment->status != 'PAGADO') {
                    return '<td><div class="btn-group" role="group"><a href="#" value="' . $id . '" OnClick="applyAgreement(' . $id . ');" class="btn btn-rounded btn-xs btn-primary mb-3"><i class="fa fa-edit"></i>Convenio</a></div></td>';
                } else {
                    return 'Pago aplicado';
                }
            })
            ->rawColumns(['description', 'payment', 'agreement'])
            ->make(true);
    }

    public function received(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $payment = Payment::find($request->id_payment);
            //Get Data
            $debt = DB::table('debts')
                ->where('id', '=', $payment->debt_id)
                ->where('status', '=', 'ACTIVA')
                ->first();

            $inscription = StudentInscription::find($debt->generation_id);

            $diplomat = Diplomat::find($inscription->diplomat_id);
            $generation = Generation::find($inscription->generation_id);

            if ($this->checkNumberPayment($payment->number_payment, $debt->id)) {
                $number_payment = $payment->number_payment;
            } else {
                DB::rollBack();
                return response()
                    ->json([
                        'message' => 'Pago ya procesado antes.',
                        'status' => 406,
                    ], 406);
            }

            $received = new PaymentReceived();
            $received->diplomat_id = $diplomat->id;
            $received->generation_id = $generation->id;
            $received->student_id = $inscription->student_id;
            $received->date_payment = $request->date_payment;
            $received->observation = 'null';
            $received->payment_method = $request->payment_method;
            $received->destination_account = $request->destination_account;
            $received->account_type = $request->account_type;
            $received->amount = $request->amount;
            $received->discount = 0;
            $received->total = $request->amount;
            $received->type = '1';
            $received->number_pay = $number_payment;
            $received->debt_id = $debt->id;
            $received->save();

            $payment_process = Payment::where('debt_id', '=', $debt->id)
                ->where('number_payment', '=', $number_payment)
                ->first();

            $agreement = DB::table('agreements')
                ->where('debt_id', $debt->id)
                ->where('num_pay', $number_payment)
                ->update(['status' => 0]);

            if ($payment_process) {
                $payment_process->amount_paid = $received->amount;
                $payment_process->date = $received->date_payment;
                $payment_process->status = 'PAGADO';
                $payment_process->income_id = $received->id;
                $payment_process->save();
            }

            if ($this->adjustDebt($debt->id, $received->total)) {
                $this->sumAccount($received->destination_account, $received->total);

                DB::commit();
                return response()->json([
                    "message" => "success",
                ]);
            } else {
                DB::rollBack();
                return response()
                    ->json([
                        'message' => 'Cantidad mayor a la deuda.',
                        'error' => 1,
                    ],400);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function processAgreement(Request $request)
    {
        try {
            DB::beginTransaction();

            //Get Data
            $debt = DB::table('debts')
                ->where('id', '=', $request->debt_id)
                ->where('status', '=', 'ACTIVA')
                ->first();

            $inscription = StudentInscription::find($debt->generation_id);

            $diplomat = Diplomat::find($inscription->diplomat_id);
            $generation = Generation::find($inscription->generation_id);

            $agreement = new Agreement();
            $agreement->date = $request->date_payment;
            $agreement->amount = $request->amount;
            $agreement->num_pay = $request->number_payment;
            $agreement->debt_id = $debt->id;
            $agreement->save();

            DB::commit();
            return response()->json([
                "message" => "success",
            ]);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function adjustDebt($debt, $amount)
    {
        $debt = Debt::find($debt);
        if ($amount <= $debt->amount) {
            $debt->amount = $debt->amount - $amount;
            $debt->save();

            if ($debt->amount == 0) {
                $debt->status = 'PAGADA';
                $debt->save();
            }
            return true;
        } else {
            return false;
        }
    }

    public function sumAccount($account, $amount)
    {
        $account = Account::find($account);
        $account->opening_balance = $account->opening_balance + $amount;
        $account->save();

        return true;
    }

    public function checkNumberPayment($number_payment, $debt)
    {
        $payment_process = Payment::where('debt_id', '=', $debt)
            ->where('number_payment', '=', $number_payment)
            ->where('status', '=', 'PENDIENTE')
            ->first();

        if ($payment_process) {
            return true;
        } else {
            return false;
        }
    }
}
