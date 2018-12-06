<?php

namespace App\Http\Controllers;

use App\Diplomat;
use App\Generation;
use App\Http\Requests\StoreGeneration;
use App\Student;
use App\Teacher;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class GenerationController extends Controller
{
    public function index(Request $request)
    {
        $diplomats = Diplomat::all();
        $docents = Teacher::all();
        return view('generations.index', compact('diplomats', 'docents'));
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
        $generations = Generation::select(['id', 'name_diplomat', 'docent', 'number_generation', 'number_students',
            'cost', 'number_payments', 'note', 'created_at']);

        return Datatables::of($generations)
            ->addColumn('action', function ($generation) {
                $id = $generation->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><a href="generaciones/alumnos/inscritos/' . $id . '" class="btn btn-rounded btn-xs btn-info mb-3"><i class="fa fa-users"></i>Alumnos</a><button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->make(true);
    }

    public function studentsInscription($id)
    {
        $generation = Generation::find($id);

        $students = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            // ->join('debts', 'debts.student_id', '=', 'students.id')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->select('students.name as name', 'students.last_name as last_name', 'students.mother_last_name as mother_last_name', 'student_inscriptions.created_at as date')
            ->get();

        return view('generations.students', compact('students', 'generation'));
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
                $generation->number_payments = $request->number_payments;
                $generation->note = $request->note;
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

    public function update(StoreGeneration $request, $id)
    {
        $generation = Generation::find($id);
        $generation->fill($request->all());
        $generation->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        Generation::find($id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
