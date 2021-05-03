<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Debt;
use App\DeudaSeminario;
use App\Diplomat;
use App\Generation;
use App\Http\Requests\StoreGeneration;
use App\InscripcionSeminarioGrupo;
use App\Low;
use App\Password;
use App\Seminario;
use App\Student;
use App\StudentInscription;
use App\Teacher;
use DB;
use Illuminate\Support\Facades\Input;
use Mail;
use PDF;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Yajra\Datatables\Datatables;

class GeneralController extends Controller
{
    public function index(Request $request)
    {
        return view('sellers.generations');
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
                <a href="/datos/generaciones/alumnos/inscritos/' . $id . '" class="btn btn-rounded btn-xs btn-info mb-3"><i class="fa fa-eye"></i> Detalles</a>
                </div></td>';
            })
            ->make(true);
    }

    public function studentsInscription($id)
    {
        $generation = Generation::find($id);

        $students = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->leftJoin('debts', 'debts.generation_id', '=', 'student_inscriptions.id')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->select(
                DB::raw('CONCAT(students.name," ",students.last_name," ",students.mother_last_name) as full_name'),
                'students.email as email',
                'students.enrollment',
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


        // $cost = DB::table('student_inscriptions')
        //     ->where('student_inscriptions.generation_id', '=', $id)
        //     ->sum('final_cost');

        $cost = DB::table('student_inscriptions')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->sum('final_cost');

        $debt_global = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->leftJoin('debts', 'debts.generation_id', '=', 'student_inscriptions.id')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->sum('debts.amount');

        return view('sellers.students', compact('students', 'generation', 'cost', 'debt_global'));
        // return $students;

    }


    public function getPasswordMaster($psd_in)
    {
        $psd = Password::where('name', '=', 'MasterKey')->first();

        if ($psd->password === $psd_in) {
            return response()->json([
                'success' => true,
                'psd' => $psd->password
            ]);
        } else {
            return response()->json([
                'success' => false,
                'psd' => $psd->password
            ]);
        }
    }

    public function enrollment()
    {
        $students = Student::all();

        foreach ($students as $key => $student) {
            $student->enrollment = 'SER00000000' . $student->id;
            $student->save();
        }
        return "success";
    }

    public function corregirSeminarios()
    {
        $inscripciones = InscripcionSeminarioGrupo::all();

        foreach ($inscripciones as $key => $ins) {
            $seminario = Seminario::where('id', '=', $ins->seminario_id)->first();
            $deuda = DeudaSeminario::where('inscripcion_id', '=', $ins->id)->first();
            $deuda->monto = $seminario->precio_venta - ($ins->descuento + $ins->primer_pago);
            $deuda->save();

            $ins->costo_final = $seminario->precio_venta;
            $ins->save();
        }

        return "ok";
    }
}
