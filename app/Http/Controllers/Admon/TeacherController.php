<?php

namespace App\Http\Controllers\Admon;

use App\Teacher;
use App\Http\Requests\StoreTeacher;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        return view('admon.teachers.index');
    }

    public function dataTeachers()
    {
        $teachers = Teacher::select(['id', 'name', 'last_name', 'mother_last_name', 'birthdate', 'sex', 'phone', 'email', 'address', 'joining_date','name_bank', 'number_target_bank', 'key_bank']);

        return Datatables::of($teachers)
            ->addColumn('action', function ($teacher) {
                $id = $teacher->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" OnClick="DeleteMod('.$id.');" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
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

    public function destroy(Request $request)
    {
        Teacher::find($request->id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
