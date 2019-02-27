<?php

namespace App\Http\Controllers;

use App\Campaing;
use App\Http\Requests\StoreCampaing;
use App\Student;
use Auth;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CampaingController extends Controller
{
    public function index(Request $request)
    {
        return view('campaings.index');
    }

    public function dataCampaings()
    {
        $campaings = Campaing::where('user_id', '=', Auth::user()->id)
            ->select(['id', 'subject', 'name', 'html_url', 'send_date', 'message', 'type', 'status'])
            ->get();

        return Datatables::of($campaings)
            ->addColumn('action', function ($campaing) {
                $id = $campaing->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button>
                <button class="btn btn-rounded btn-xs btn-success mb-3" value="' . $id . '" OnClick="addStudents(this);" data-toggle="modal" data-target="#modaladdStudents"><i class="fa fa-plus-square"></i> Agregar Destinatarios</button>
                <button class="btn btn-rounded btn-xs btn-primary mb-3" value="' . $id . '" OnClick="showStudents(this);" data-toggle="modal" data-target="#modaladdStudentsShow"><i class="fa fa-eye"></i> Ver Destinatarios</button>
                </div>
                </td>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function dataStudents()
    {
        $students = Student::where('user_id', '=', Auth::user()->id)
            ->select(['id', 'name', 'last_name', 'mother_last_name', 'curp', 'phone', 'email', 'facebook'])
            ->get();

        return Datatables::of($students)
            ->addColumn('checkbox', function ($student) {
                $id = $student->id;
                return '<td><input type="checkbox" name="student_checkbox[]" class="student_checkbox" value="' . $id . '"></td>';
            })
            ->rawColumns(['checkbox'])
            ->make(true);
    }

    public function store(StoreCampaing $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            $campaing = new Campaing();
            $campaing->subject = $request->subject;
            $campaing->name = $request->name;
            $campaing->html_url = $request->html_url;
            $campaing->send_date = $request->send_date;
            $campaing->message = $request->message;
            $campaing->type = $request->type;
            $campaing->user_id = Auth::user()->id;
            $campaing->save();

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

    public function update(StoreCampaing $request, $id)
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

    public function addStudents(Request $request)
    {
        $campaing = $request->campaing;
        $student_id_array = $request->input('id');

        $student = Student::whereIn('id', $student_id_array);

        foreach ($student_id_array as $student) {
            DB::table('campaing_student')->insert(
                ['campaing_id' => $campaing, 'student_id' => $student]
            );
        }

        return "success";
    }
}
