<?php

namespace App\Http\Controllers;

use App\Account;
use App\CatClasification;
use App\CatExpense;
use App\CatReference;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CatExpensesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $accounts = Account::all();
        $cat_references = CatReference::where('erased', '=', 0)->get();
        $cat_clasifications = CatClasification::where('erased', '=', 0)->get();
        return view('admon.expenses.index', compact('accounts', 'cat_references', 'cat_clasifications'));
    }

    public function data()
    {
        $cats = CatExpense::join('accounts', 'cat_expenses.account_id', '=', 'accounts.id')
            ->join('cat_references', 'cat_expenses.cat_reference', '=', 'cat_references.id')
            ->join('cat_clasifications', 'cat_expenses.cat_clasification', '=', 'cat_clasifications.id')
            ->select(
                'cat_expenses.date as date',
                'accounts.account_name as account',
                'cat_expenses.concept as concept',
                'cat_clasifications.name as clasification',
                'cat_expenses.amount as amount',
                'cat_references.name as reference'
            )->get();

        return Datatables::of($cats)
            ->addColumn('action', function ($cat) {
                return '<div class="btn-group">
          <button type="button" class="btn btn-primary" value="' . $cat->id . '" onClick="editCat(' . $cat->id . ');" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i>
          </button>
          <button type="button" value="' . $cat->id . '" OnClick="DeleteCat(this);" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i>
          </button>
          </div>';
            })
            ->make(true);
    }

    public function getCats(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = CatExpense::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $medicine = new CatExpense();
                $medicine->name = $request->name;
                $medicine->save();

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }

    public function get($id)
    {
        $cat = CatExpense::find($id);
        return response()->json(['cat' => $cat]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            try {

                $cat = CatExpense::find($id);
                $cat->name = $request->name;
                $cat->save();

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }
    
    public function delete($id)
    {
        $cat = CatExpense::find($id);
        $cat->erased = 1;
        $cat->save();
        return response()->json("sucess");
    }
}
