<?php

namespace App\Http\Controllers\Auxiliar;

use App\Account;
use App\AccountType;
use App\Debt;
use App\Diplomat;
use App\Generation;
use App\Http\Requests\StoreGeneration;
use App\Low;
use App\Student;
use App\StudentInscription;
use App\Teacher;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;
use PDF;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Payment;
use App\PaymentMethod;
use App\User;

class GenerationController extends Controller
{
    public function index(Request $request)
    {
        $diplomats = Diplomat::all();
        $docents = Teacher::all();
        return view('auxiliar.generations.index', compact('diplomats', 'docents'));
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
            'cost', 'commision', 'full_price', 'created_at'
        ]);

        return Datatables::of($generations)
            ->addColumn('action', function ($generation) {
                $id = $generation->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <a href="/auxiliar/generaciones/alumnos/inscritos/' . $id . '" class="btn btn-rounded btn-xs btn-info mb-3"><i class="fa fa-eye"></i> Detalles</a>
                <button class="btn btn-rounded btn-xs btn-primary mb-3" value="' . $id . '" OnClick="Show(this);" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                </div></td>';
            })
            ->make(true);
    }

    public function listStudentsGeneration($id)
    {
        $generation = Generation::find($id);
        $metodos = PaymentMethod::all();
        $cuentas = Account::all();
        $generations = Generation::all();
        $diplomats = Diplomat::all();
        $accounts = Account::all();
        $methods = PaymentMethod::all();
        $account_types = AccountType::all();

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
                'student_inscriptions.baja as baja',
                'student_inscriptions.fecha_baja as fecha_baja',
                'student_inscriptions.final_cost as costo_final',
                'student_inscriptions.status as status',
                'debts.amount as debe',
                'debts.id as debt_id'
            )
            ->get();


        return view('auxiliar.generations.estudiantes-inscritos', compact('estudiantes', 'generation', 'metodos', 'cuentas', 'diplomats', 'generations', 'accounts', 'methods', 'account_types'));
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

    public function GenerarConvenio(Request $request)
    {
        try {
            $pago = Payment::find($request->id);
            $deuda = Debt::where('id', '=', $pago->debt_id)->first();
            $inscripcion = StudentInscription::find($deuda->generation_id);

            $pago->convenio = true;
            $pago->fecha_pago_convenio = $request->fecha;
            $pago->monto_convenio = $request->monto;
            $pago->save();

            return response()->json($inscripcion);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    

    public function getConvenios()
    {
        $convenios = Payment::join('diplomats', 'diplomats.id', '=', 'payments.diplomat_id')
        ->join('generations', 'generations.id', '=', 'payments.generation_id')
        ->join('students', 'students.id', '=', 'payments.student_id')
        ->select(
            'diplomats.name as diplomado',
            'generations.number_generation as generacion',
            DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as estudiante'),
            'payments.fecha_pago_convenio as fecha',
            'payments.monto_convenio as monto'
        )
        ->where('convenio', '=', true)->get();

        return Datatables::of($convenios)
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
                $generation->cost = $diplomat->cost;
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
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        $generation = Generation::find($id);
        if ($generation->number_students = 0) {
            Generation::find($id)->delete();
            return response()->json([
                'success' => 'Record has been deleted successfully!',
            ]);
        } else {
            return error;
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
}
