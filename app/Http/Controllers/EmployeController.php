<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditEmploye;
use App\Http\Requests\StoreEmploye;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class EmployeController extends Controller
{   
    function __construct()
    {
        //$this->middleware('permission:modulo-administracion');
    }

    public function index(Request $request)
    {   
        $roles = Role::all();
        return view('employees.index', compact('roles'));
    }

    public function dataEmployes()
    {
        $employees = User::select(['id', 'name', 'email']);

        return Datatables::of($employees)
            ->addColumn('action', function ($employe) {
                $id = $employe->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button>
                </div></td>';
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

            if ($request->role) {
                $role = Role::find($request->role);
                $employe->assignRole($role);
            }

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);
        // Get the roles
        $roles = Role::find($roles);
        // check for current role changes
        if (!$user->hasAllRoles($roles)) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }
        $user->syncRoles($roles);
        return $user;
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
