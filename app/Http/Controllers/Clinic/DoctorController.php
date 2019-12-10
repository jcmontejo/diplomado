<?php

namespace App\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Doctor;
use App\Http\Requests\StoreDoctor;
use Yajra\Datatables\Datatables;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        return view('clinic.doctors.index');
    }

    public function dataTeachers()
    {
        $doctors = Doctor::where('status', '=', 1)->select(['id', 'name', 'lastname', 'phone', 'email']);

        return Datatables::of($doctors)
            ->addColumn('action', function ($doctor) {
                $id = $doctor->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->make(true);
    }

    public function store(StoreDoctor $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            Doctor::create($request->all());

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $doctor = Doctor::find($id);
        return response()->json($doctor);
    }

    public function update(StoreDoctor $request, $id)
    {
        $doctor = Doctor::find($id);
        $doctor->fill($request->all());
        $doctor->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        $doctor->status = 0;
        $doctor->save();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
