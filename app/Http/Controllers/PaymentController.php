<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountType;
use App\Debt;
use App\Diplomat;
use App\Generation;
use App\Http\Requests\StorePaymentReceived;
use App\PaymentMethod;
use App\PaymentReceived;
use App\StudentInscription;
use DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use PDF;

class PaymentController extends Controller
{

    public function showReceiveds()
    {
        return view('incomes.index');
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
                    return '<td><div class="btn-group" role="group" aria-label="Basic example"><a href="/descargar/recibo/' . $id . '" class="btn btn-rounded btn-xs btn-info mb-3"><i class="fa fa-print"></i> Recibo</a></div></td>';
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
            $received->debt_id = $debt->id;
            $received->save();

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

    public function voucher($id)
    {   
        $data = PaymentReceived::find($id);

        $pdf = PDF::loadView('payments.voucher',compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('comprobante-de-pago.pdf');
    }
}
