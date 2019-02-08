<?php

namespace App\Http\Controllers;

use App\Account;
use App\Expense;
use App\Http\Requests\StoreExpense;
use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $accounts = Account::all();

        return view('expenses.index', compact('users', 'accounts'));
    }

    public function dataExpenses()
    {
        $expenses = Expense::select(['id', 'concept', 'amount', 'description']);

        return Datatables::of($expenses)
            ->addColumn('action', function ($expense) {
                $id = $expense->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->make(true);
    }

    public function store(StoreExpense $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            $account = Account::find($request->account_id);

            if ($account->opening_balance >= $request->amount) {
                $expense = new Expense();
                $expense->concept = $request->concept;
                $expense->amount = $request->amount;
                $expense->description = $request->description;

                if ($request->hasFile('voucher')) {
                    $extension = $request->file('voucher');
                    $extension = $request->file('voucher')->getClientOriginalExtension(); // getting excel extension
                    $dir = 'assets/files/expenses';
                    $voucher = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
                    $request->file('voucher')->move($dir, $voucher);

                    // Save Document
                    $expense->voucher = $voucher;
                }

                $expense->user_id = $request->user_id;
                $expense->account_id = $request->account_id;
                $expense->save();

                $account->opening_balance = $account->opening_balance - $expense->amount;
                $account->save();
                return response()->json([
                    "message" => "success",
                ]);

            } else {
                return response()
                    ->json([
                        'message' => 'Saldo insuficiente.',
                        'status' => 406,
                    ], 406);
            }
        }
    }

    public function edit($id)
    {
        $expense = Expense::find($id);
        return response()->json($expense);
    }

    public function update(StoreExpense $request, $id)
    {
        $account = Account::find($request->account_id);
        $expense = Expense::find($id);

        $account->opening_balance = $account->opening_balance + $expense->amount;
        $account->save();

        $expense->concept = $request->concept;
        $expense->amount = $request->amount;
        $expense->description = $request->description;

        if ($request->hasFile('voucher')) {
            $extension = $request->file('voucher');
            $extension = $request->file('voucher')->getClientOriginalExtension(); // getting excel extension
            $dir = 'assets/files/expenses';
            $voucher = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
            $request->file('voucher')->move($dir, $voucher);

            // Save Document
            $expense->voucher = $voucher;
        }

        $expense->user_id = $request->user_id;
        $expense->account_id = $request->account_id;
        $expense->save();

        $account->opening_balance = $account->opening_balance - $expense->amount;
        $account->save();

        return response()->json(["message" => "success"]);
    }
}
