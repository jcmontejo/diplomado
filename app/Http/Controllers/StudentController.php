<?php

namespace App\Http\Controllers;

use App\Student;
use App\Http\Requests\StoreStudent;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        return view('students.index');
    }

    public function dataStudents()
    {
        $students = Student::select(['id', 'name', 'last_name', 'mother_last_name', 'birthdate', 'sex', 'phone', 'address', 'email']);

        return Datatables::of($students)
            ->addColumn('action', function ($student) {
                $id = $student->id;
                return '<td><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></td>';
            })
            ->make(true);
    }

    public function store(StoreStudent $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            Student::create($request->all());

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update(StoreStudent $request, $id)
    {
        $student = Student::find($id);
        $student->fill($request->all());
        $student->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        Student::find($id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
