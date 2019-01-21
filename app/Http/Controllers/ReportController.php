<?php

namespace App\Http\Controllers;

use DB;
use Yajra\Datatables\Datatables;

class ReportController extends Controller
{

    public function showDebts()
    {
        return view('reports.debts');
    }

    public function debts()
    {
        $debts = DB::table('student_inscriptions')
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
                'students.curp as curp_student',
                'students.enrollment as enrollment_student',
                'students.phone as phone_student',
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as student'),
                'debts.amount as debt',
                'student_inscriptions.final_cost as total'
            )
            ->where('debts.status', '=', 'ACTIVA')
            ->orderBy('diplomats.name', 'asc')
            ->get();

        return Datatables::of($debts)
            ->addColumn('total_payment', function ($debt) {
                $total_payment = $debt->total - $debt->debt;
                return $total_payment;
            })
            ->make(true);
    }

    public function showNoDocuments()
    {
        return view('reports.no-documents');
    }

    public function noDocuments()
    {
        $students = DB::table('student_inscriptions')
            ->leftJoin('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->leftJoin('diplomats', 'student_inscriptions.diplomat_id', '=', 'diplomats.id')
            ->leftJoin('generations', 'student_inscriptions.generation_id', '=', 'generations.id')
            ->select(
                'diplomats.id as diplomat_id',
                'diplomats.name as diplomat_name',
                'generations.id as generation_id',
                'generations.number_generation as generation_number',
                'student_inscriptions.id as student_id',
                'students.curp as curp_student',
                'students.enrollment as enrollment_student',
                'students.phone as phone_student',
                'students.documents as document',
                'students.id as id',
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as student')
            )
            ->whereNull('students.documents')
            ->orderBy('diplomats.name', 'asc')
            ->get();

        return Datatables::of($students)
            ->addColumn('action', function ($student) {
                $id = $student->id;

                return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <button class="btn btn-rounded btn-xs btn-primary mb-3" value="' . $id . '" OnClick="addDocuments(this);" data-toggle="modal" data-target="#modalAddDocuments"><i class="fa fa-plus"></i> Agregar Documentos</button>
                </div>
                </td>';
            })
            ->make(true);
    }

}
