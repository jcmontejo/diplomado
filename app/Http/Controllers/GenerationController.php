<?php

namespace App\Http\Controllers;

use App\Diplomat;
use App\Generation;
use App\Http\Requests\StoreGeneration;
use App\Student;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class GenerationController extends Controller
{
    public function index(Request $request)
    {
        $diplomats = Diplomat::all();
        return view('generations.index', compact('diplomats'));
    }

    public function findStudent(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $students = Student::select('name', 'last_name', 'mother_last_name')
            ->where('name','like', '%' . $term . '%')
            ->orderBy('name', 'desc')->get();

        $formatted_tags = [];

        foreach ($students as $student) {
            $formatted_tags[] = ['id' => $student->id, 'text' => $student->name];
        }

        return \Response::json($formatted_tags);
    }

    public function dataGenerations()
    {
        $generations = Generation::select(['id', 'name_diplomat', 'number_generation', 'number_students',
            'cost', 'number_payments', 'note', 'created_at']);

        return Datatables::of($generations)
            ->addColumn('action', function ($generation) {
                $id = $generation->id;
                return '<td><button class="btn btn-rounded btn-xs btn-success mb-3" value="' . $id . '" OnClick="addStudents(this);"><i class="fa fa-plus"></i> Matricular</button><button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></td>';
            })
            ->make(true);
    }

    public function store(StoreGeneration $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            $diplomat = Diplomat::find($request->name_diplomat);

            $generation = new Generation();
            $generation->name_diplomat = $diplomat->name;
            $generation->number_generation = $request->number_generation;
            $generation->cost = $diplomat->cost;
            $generation->number_payments = $request->number_payments;
            $generation->note = $request->note;
            $generation->status = $request->status;
            $generation->diplomat_id = $diplomat->id;
            $generation->save();

            return response()->json([
                "message" => "success",
            ]);
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
