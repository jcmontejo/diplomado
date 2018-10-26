<?php

namespace App\Http\Controllers;

use App\Teacher;
use App\Http\Requests\StoreTeacher;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        return view('teachers.index');
    }

    public function dataTeachers()
    {
        $teachers = Teacher::select(['id', 'name', 'last_name', 'mother_last_name', 'birthdate', 'sex', 'phone', 'email', 'address', 'joining_date']);

        return Datatables::of($teachers)
            ->addColumn('action', function ($teacher) {
                $id = $teacher->id;
                return '<td><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal" data-target="#modalEdit">Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);">Eliminar</button></td>';
            })
            ->make(true);
    }

    public function store(StoreTeacher $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            Teacher::create($request->all());

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $teacher = Teacher::find($id);
        return response()->json($teacher);
    }

    public function update(StoreTeacher $request, $id)
    {
        $teacher = Teacher::find($id);
        $teacher->fill($request->all());
        $teacher->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        Teacher::find($id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
