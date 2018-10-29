<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditEmploye;
use App\Http\Requests\StoreEmploye;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class EmployeController extends Controller
{
    public function index(Request $request)
    {
        return view('employees.index');
    }

    public function dataEmployes()
    {
        $employees = User::select(['id', 'name', 'email']);

        return Datatables::of($employees)
            ->addColumn('action', function ($employe) {
                $id = $employe->id;
                return '<td><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></td>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(StoreEmploye $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();

            $employe = new User();
            $employe->name = $request->name;
            $employe->email = $request->email;
            $employe->password = Hash::make($request->password);
            $employe->save();

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $employe = User::find($id);
        return response()->json($employe);
    }

    public function update(EditEmploye $request, $id)
    {
        $employe = User::find($id);
        $employe->name = $request->name;
        $employe->email = $request->email;
        // check for password change
        if ($request->get('password')) {
            $employe->password = bcrypt($request->get('password'));
        }
        $employe->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
