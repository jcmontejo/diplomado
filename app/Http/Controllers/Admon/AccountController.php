<?php

namespace App\Http\Controllers\Admon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccount;
use App\Account;
use Yajra\Datatables\Datatables;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        return view('admon.accounts.index');
    }

    public function dataAccounts()
    {
        $accounts = Account::select(['id', 'account_name', 'opening_balance', 'note']);

        return Datatables::of($accounts)
            ->addColumn('action', function ($account) {
                $id = $account->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" OnClick="DeleteMod('.$id.');" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(StoreAccount $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            Account::create($request->all());

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $diplomat = Account::find($id);
        return response()->json($diplomat);
    }

    public function update(StoreAccount $request, $id)
    {
        $account = Account::find($id);
        $account->fill($request->all());
        $account->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy(Request $request)
    {
        Account::find($request->id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
