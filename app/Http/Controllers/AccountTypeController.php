<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountType;
use Yajra\Datatables\Datatables;
use App\AccountType;

class AccountTypeController extends Controller
{
    public function index(Request $request)
    {
        return view('account_types.index');
    }

    public function dataAccounts()
    {
        $accounts = AccountType::select(['id', 'account_type', 'account_code', 'note']);

        return Datatables::of($accounts)
            ->addColumn('action', function ($account) {
                $id = $account->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('account_types.create');
    }

    public function store(StoreAccountType $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            AccountType::create($request->all());

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $account = AccountType::find($id);
        return response()->json($account);
    }

    public function update(StoreAccountType $request, $id)
    {
        $account = AccountType::find($id);
        $account->fill($request->all());
        $account->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        AccountType::find($id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
