<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountType;
use App\Debt;
use App\Diplomat;
use App\Generation;
use App\Http\Requests\StorePaymentReceived;
use App\Payment;
use App\PaymentMethod;
use App\PaymentReceived;
use App\StudentInscription;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PDF;
use Yajra\Datatables\Datatables;

class PaymentController extends Controller
{

    public function showReceiveds()
    {
        return view('incomes.index');
    }

    public function showPayments()
    {
        $accounts = Account::all();
        $methods = PaymentMethod::all();
        $account_types = AccountType::all();

        return view('incomes.payments', compact('accounts', 'methods', 'account_types'));
    }

    public function paymentReceiveds()
    {
        $start_date = Input::get('one');
        $end_date = Input::get('second');

        if ($start_date == '' and $end_date == '') {
            $receiveds = DB::table('payment_receiveds')
                ->join('diplomats', 'payment_receiveds.diplomat_id', '=', 'diplomats.id')
                ->join('generations', 'payment_receiveds.generation_id', '=', 'generations.id')
                ->join('students', 'payment_receiveds.student_id', '=', 'students.id')
                ->join('payment_methods', 'payment_receiveds.payment_method', '=', 'payment_methods.id')
                ->join('accounts', 'payment_receiveds.destination_account', '=', 'accounts.id')
                ->join('account_types', 'payment_receiveds.account_type', '=', 'account_types.id')
                ->select(
                    'payment_receiveds.id as id',
                    'diplomats.name as diplomat',
                    'generations.number_generation as generation',
                    DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as student'),
                    'students.enrollment',
                    'students.curp',
                    'payment_receiveds.date_payment as date',
                    'payment_receiveds.observation as observation',
                    'payment_methods.name as method',
                    'accounts.account_name as destination',
                    'account_types.account_type as type',
                    'payment_receiveds.amount as amount',
                    'payment_receiveds.discount as discount',
                    'payment_receiveds.total as total'
                )->get();
            //
            return Datatables::of($receiveds)
                ->addColumn('action', function ($received) {
                    $id = $received->id;
                    if (Auth::user()->hasRole('Control Escolar')) {
                        return '<td><div class="btn-group" role="group" aria-label="Basic example">
                    <button class="btn btn-warning">Sin privilegios</button>
                    </div></td>';
                    } else {
                        return '<td><div class="btn-group" role="group" aria-label="Basic example">
                    <a href="/descargar/recibo/' . $id . '" class="btn btn-rounded btn-xs btn-info mb-3"><i class="fa fa-print"></i> Recibo</a>
                    <button value="' . $id . '" OnClick="sendVoucher(this);" class="btn btn-rounded btn-xs btn-dark mb-3"><i class="fa fa-envelope"></i> Enviar recibo</button>
                    </div></td>';
                    }
                })
                ->make(true);
        } else {
            $receiveds = DB::table('payment_receiveds')
                ->join('diplomats', 'payment_receiveds.diplomat_id', '=', 'diplomats.id')
                ->join('generations', 'payment_receiveds.generation_id', '=', 'generations.id')
                ->join('students', 'payment_receiveds.student_id', '=', 'students.id')
                ->join('payment_methods', 'payment_receiveds.payment_method', '=', 'payment_methods.id')
                ->join('accounts', 'payment_receiveds.destination_account', '=', 'accounts.id')
                ->join('account_types', 'payment_receiveds.account_type', '=', 'account_types.id')
                ->select(
                    'payment_receiveds.id as id',
                    'diplomats.name as diplomat',
                    'generations.number_generation as generation',
                    DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as student'),
                    'students.enrollment as enrollment',
                    'students.curp as curp',
                    'payment_receiveds.date_payment as date',
                    'payment_receiveds.observation as observation',
                    'payment_methods.name as method',
                    'accounts.account_name as destination',
                    'account_types.account_type as type',
                    'payment_receiveds.amount as amount',
                    'payment_receiveds.discount as discount',
                    'payment_receiveds.total as total'
                )
                ->whereBetween('payment_receiveds.date_payment', [$start_date, $end_date])->get();

            return Datatables::of($receiveds)
                ->addColumn('action', function ($received) {
                    $id = $received->id;
                    return '<td><div class="btn-group" role="group" aria-label="Basic example"><a href="/descargar/recibo/' . $id . '" class="btn btn-rounded btn-xs btn-info mb-3"><i class="fa fa-print"></i> Recibo</a></div></td>';
                })
                ->make(true);
        }
    }

    public function paymentReceivedsForRevert()
    {
        $start_date = Input::get('one');
        $end_date = Input::get('second');

        if ($start_date == '' and $end_date == '') {
            $receiveds = DB::table('payment_receiveds')
                ->join('diplomats', 'payment_receiveds.diplomat_id', '=', 'diplomats.id')
                ->join('generations', 'payment_receiveds.generation_id', '=', 'generations.id')
                ->join('students', 'payment_receiveds.student_id', '=', 'students.id')
                ->join('payment_methods', 'payment_receiveds.payment_method', '=', 'payment_methods.id')
                ->join('accounts', 'payment_receiveds.destination_account', '=', 'accounts.id')
                ->join('account_types', 'payment_receiveds.account_type', '=', 'account_types.id')
                ->select(
                    'payment_receiveds.id as id',
                    'diplomats.name as diplomat',
                    'generations.number_generation as generation',
                    DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as student'),
                    'students.enrollment as enrollment',
                    'students.curp as curp',
                    'payment_receiveds.date_payment as date',
                    'payment_receiveds.observation as observation',
                    'payment_methods.name as method',
                    'accounts.account_name as destination',
                    'account_types.account_type as type',
                    'payment_receiveds.amount as amount',
                    'payment_receiveds.discount as discount',
                    'payment_receiveds.total as total'
                )->get();
            //
            return Datatables::of($receiveds)
                ->addColumn('action', function ($received) {
                    $id = $received->id;
                    return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button></div></td>';
                })
                ->make(true);
        } else {
            $receiveds = DB::table('payment_receiveds')
                ->join('diplomats', 'payment_receiveds.diplomat_id', '=', 'diplomats.id')
                ->join('generations', 'payment_receiveds.generation_id', '=', 'generations.id')
                ->join('students', 'payment_receiveds.student_id', '=', 'students.id')
                ->join('payment_methods', 'payment_receiveds.payment_method', '=', 'payment_methods.id')
                ->join('accounts', 'payment_receiveds.destination_account', '=', 'accounts.id')
                ->join('account_types', 'payment_receiveds.account_type', '=', 'account_types.id')
                ->select(
                    'payment_receiveds.id as id',
                    'diplomats.name as diplomat',
                    'generations.number_generation as generation',
                    DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as student'),
                    'students.enrollment as enrollment',
                    'students.curp as curp',
                    'payment_receiveds.date_payment as date',
                    'payment_receiveds.observation as observation',
                    'payment_methods.name as method',
                    'accounts.account_name as destination',
                    'account_types.account_type as type',
                    'payment_receiveds.amount as amount',
                    'payment_receiveds.discount as discount',
                    'payment_receiveds.total as total'
                )
                ->whereBetween('payment_receiveds.date_payment', [$start_date, $end_date])->get();

            return Datatables::of($receiveds)
                ->addColumn('action', function ($received) {
                    $id = $received->id;
                    return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button></div></td>';
                })
                ->make(true);
        }
    }

    public function processPayment()
    {
        $diplomats = Diplomat::all();
        $types = AccountType::all();
        $paymentMethods = PaymentMethod::all();
        $accounts = Account::all();

        return view('payments.process', compact('diplomats', 'types', 'paymentMethods', 'accounts'));
    }

    public function listGenerations($id)
    {
        $generations = DB::table("generations")
            ->where("diplomat_id", $id)
            ->pluck("number_generation", "id");
        return json_encode($generations);
    }

    public function debt($id)
    {
        $inscription = StudentInscription::find($id);
        $debt = DB::table('debts')
            ->select('amount')
            ->where('generation_id', '=', $inscription->id)
            ->where('status', '=', 'ACTIVA')
            ->first();

        return json_encode($debt);
    }

    public function listStudents($id)
    {
        $students = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('debts', 'student_inscriptions.student_id', '=', 'debts.student_id')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->where('debts.status', '=', 'ACTIVA')
            ->select(DB::raw("CONCAT(students.name,' ',students.last_name,' ',students.mother_last_name ) AS name, student_inscriptions.id"))
            ->pluck('name', 'id');

        return json_encode($students);
    }

    public function dataPayment($curp)
    {
        $student = DB::table('students')->where('curp', '=', $curp)->first();

        if ($student) {
            $inscription = DB::table('student_inscriptions')
                ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
                ->leftJoin('diplomats', 'student_inscriptions.diplomat_id', '=', 'diplomats.id')
                ->leftJoin('generations', 'student_inscriptions.generation_id', '=', 'generations.id')
                ->leftJoin('debts', 'student_inscriptions.id', '=', 'debts.generation_id')
                ->select(
                    'diplomats.id as diplomat_id',
                    'diplomats.name as diplomat_name',
                    'generations.id as generation_id',
                    'generations.number_generation as generation_number',
                    'student_inscriptions.id as student_id',
                    'students.name as name_student',
                    'students.last_name as last_name',
                    'students.mother_last_name as mother_last_name',
                    'debts.amount as debt'
                )
                ->where('student_inscriptions.student_id', '=', $student->id)->first();
            return json_encode($inscription);
        } else {
            return response()
                ->json([
                    'message' => 'No se encontro la CURP.',
                    'status' => 400,
                ], 400);
        }
    }

    public function received(StorePaymentReceived $request)
    {
        try {
            DB::beginTransaction();

            $diplomat = Diplomat::find($request->diplomat_id);
            $generation = Generation::find($request->generation_id);
            $inscription = StudentInscription::find($request->student_id);
            $debt = DB::table('debts')
                ->where('generation_id', '=', $inscription->id)
                ->where('status', '=', 'ACTIVA')
                ->first();

            if ($this->checkNumberPayment($request->number_payment, $debt->id)) {
                $number_payment = $request->number_payment;
            } else {
                DB::rollBack();
                return response()
                    ->json([
                        'message' => 'Pagado ya procesado antes.',
                        'status' => 406,
                    ], 406);
            }

            $received = new PaymentReceived();
            $received->diplomat_id = $diplomat->id;
            $received->generation_id = $generation->id;
            $received->student_id = $inscription->student_id;
            $received->date_payment = $request->date_payment;
            $received->observation = $request->observation;
            $received->payment_method = $request->payment_method;
            $received->destination_account = $request->destination_account;
            $received->account_type = $request->account_type;
            $received->amount = $request->amount;
            $received->discount = $request->discount;
            $received->total = $request->total;
            $received->type = '1';
            $received->debt_id = $debt->id;
            $received->save();

            $payment_process = Payment::where('debt_id', '=', $debt->id)
                ->where('number_payment', '=', $number_payment)
                ->first();

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
                        'status' => 400,
                    ], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function receivedAlternate(Request $request)
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

            if ($this->checkNumberPayment($request->number_payment, $debt->id)) {
                $number_payment = $request->number_payment;
            } else {
                DB::rollBack();
                return response()
                    ->json([
                        'message' => 'Pagado ya procesado antes.',
                        'status' => 406,
                    ], 406);
            }

            $received = new PaymentReceived();
            $received->diplomat_id = $diplomat->id;
            $received->generation_id = $generation->id;
            $received->student_id = $inscription->student_id;
            $received->date_payment = $request->date_payment;
            $received->observation = $request->observation;
            $received->payment_method = $request->payment_method;
            $received->destination_account = $request->destination_account;
            $received->account_type = $request->account_type;
            $received->amount = $request->amount;
            $received->discount = $request->discount;
            $received->total = $request->amount;
            $received->type = '1';
            $received->debt_id = $debt->id;
            $received->save();

            $payment_process = Payment::where('debt_id', '=', $debt->id)
                ->where('number_payment', '=', $number_payment)
                ->first();

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
                        'status' => 400,
                    ], 400);
            }
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

    public function voucher($id)
    {
        $data = PaymentReceived::find($id);

        $pdf = PDF::loadView('payments.voucher', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('comprobante-de-pago.pdf');
    }

    public function edit($id)
    {
        $data = PaymentReceived::find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $payment = PaymentReceived::find($id);

            $account = Account::find($payment->destination_account);
            $account->opening_balance = $account->opening_balance - $payment->total;
            $account->save();

            $debt = Debt::find($payment->debt_id);
            $debt->amount = $debt->amount + $payment->total;
            $debt->save();

            $payment->amount = $request->amount;
            $payment->total = $request->amount;
            $payment->save();

            $account->opening_balance = $account->opening_balance + $payment->total;
            $account->save();

            $debt->amount = $debt->amount - $payment->total;
            $debt->save();

            DB::commit();

            return response()->json(["message" => "success"]);

        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
