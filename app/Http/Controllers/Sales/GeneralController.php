<?php

namespace App\Http\Controllers\Sales;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Debt;
use App\Diplomat;
use App\Generation;
use App\GrupoSeminario;
use App\Http\Requests\StoreGeneration;
use App\InscripcionSeminarioGrupo;
use App\Low;
use App\PaymentMethod;
use App\Student;
use App\StudentInscription;
use App\Teacher;
use DB;
use Illuminate\Support\Facades\Input;
use Mail;
use PDF;
use Yajra\Datatables\Datatables;

class GeneralController extends Controller
{
    public function index(Request $request)
    {
        return view('sales.sellers.generations');
    }

    public function dataGenerations()
    {
        $generations = Generation::select(['id', 'name_diplomat', 'docent', 'number_generation', 'number_students',
            'cost', 'commision', 'full_price', 'created_at']);

        return Datatables::of($generations)
            ->addColumn('total_inscriptions', function ($generation){
                $data = StudentInscription::where('generation_id', '=', $generation->id)->count();

                return $data;
            })
            ->addColumn('action', function ($generation) {
                $id = $generation->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <a href="/ventas/alumnos/datos/generaciones/alumnos/inscritos/' . $id . '" class="btn btn-rounded btn-xs btn-info mb-3"><i class="fa fa-eye"></i> Detalles</a>
                </div></td>';
            })
            ->make(true);
    }

    function verSeminariosGrupos()
    {
        return view('sales.seminarios.index');
    }

    function dataSeminarios ()
    {
        $rows = GrupoSeminario::select(['id', 'nombre']);

        return Datatables::of($rows)
            ->addColumn('action', function ($cat) {
                return '<div class="btn-group">
          <a href="/ventas/alumnos/datos/seminarios-grupos/todos/' . $cat->id . '" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Estudiantes"><i class="fa fa-eye"></i>
          </a>
          </div>';
            })
            ->make(true);
    }

    public function showStudents($id)
    {
        $grupo = GrupoSeminario::find($id);

        $estudiantes = InscripcionSeminarioGrupo::join('seminarios', 'inscripcion_seminario_grupos.seminario_id', '=', 'seminarios.id')
            ->join('students', 'inscripcion_seminario_grupos.student_id', '=', 'students.id')
            ->join('grupo_seminarios', 'inscripcion_seminario_grupos.grupo_id', '=', 'grupo_seminarios.id')
            ->join('deuda_seminarios', 'inscripcion_seminario_grupos.id', '=', 'deuda_seminarios.inscripcion_id')
            ->select([
                'seminarios.nombre as seminario',
                'seminarios.clave as clave_seminario',
                'grupo_seminarios.nombre as grupo',
                'students.enrollment as matricula',
                DB::raw('CONCAT(students.last_name,"/", students.mother_last_name," ",students.name) AS estudiante'),
                'inscripcion_seminario_grupos.costo_final as costo_final',
                'inscripcion_seminario_grupos.descuento as descuento',
                'inscripcion_seminario_grupos.primer_pago as primer_pago',
                'deuda_seminarios.monto as deuda',
                'inscripcion_seminario_grupos.id as ID'
            ])
            ->where('inscripcion_seminario_grupos.grupo_id', '=', $id)
            ->where('inscripcion_seminario_grupos.activo', '=', true)
            ->get();

        return view('sales.seminarios.estudiantes', compact('estudiantes', 'grupo'));
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

        return view('sales.sellers.students', compact('students', 'generation', 'cost', 'debt_global'));
        // return $students;

    }
}
