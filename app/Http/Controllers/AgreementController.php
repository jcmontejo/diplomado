<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\StudentInscription;
use App\Diplomat;
use App\Generation;
use App\Agreement;
use Yajra\Datatables\Datatables;

class AgreementController extends Controller
{

    public function list()
    {
        $convenios = DB::table('agreements')
            ->join('debts', 'debts.id', '=', 'agreements.debt_id')
            ->join('student_inscriptions', 'student_inscriptions.id', '=', 'debts.generation_id')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('diplomats', 'student_inscriptions.diplomat_id', '=', 'diplomats.id')
            ->join('generations', 'student_inscriptions.generation_id', '=', 'generations.id')
            ->where('agreements.status', '=', 1)
            ->select(
                'student_inscriptions.id as id',
                'generations.number_generation as generation',
                'diplomats.name as name_diplomat',
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as full_name'),
                'students.enrollment',
                'students.curp',
                'agreements.date as fechaEsperada',
                'agreements.amount as montoPactado',
                'agreements.num_pay as numeroPago',
                'student_inscriptions.created_at as date',
                'student_inscriptions.id as id_inscription'
            )
            ->get();

        return Datatables::of($convenios)
            ->make(true);
    }

    public function listToday()
    {
        $convenios = DB::table('agreements')
            ->join('debts', 'debts.id', '=', 'agreements.debt_id')
            ->join('student_inscriptions', 'student_inscriptions.id', '=', 'debts.generation_id')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->join('diplomats', 'student_inscriptions.diplomat_id', '=', 'diplomats.id')
            ->join('generations', 'student_inscriptions.generation_id', '=', 'generations.id')
            ->where('agreements.status', '=', 1)
            ->where('agreements.date', '=', \Carbon\Carbon::now()->toDateString())
            ->select(
                'student_inscriptions.id as id',
                'generations.number_generation as generation',
                'diplomats.name as name_diplomat',
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as full_name'),
                'students.enrollment',
                'students.curp',
                'agreements.date as fechaEsperada',
                'agreements.amount as montoPactado',
                'agreements.num_pay as numeroPago',
                'student_inscriptions.created_at as date',
                'student_inscriptions.id as id_inscription'
            )
            ->get();

        return Datatables::of($convenios)
            ->make(true);
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
}
