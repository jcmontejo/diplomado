<?php

namespace App\Http\Controllers;

use App\CatClasification;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CatClasificationController extends Controller
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

        return view('admon.clasifications.index');
    }

    public function data()
    {
        $cats = CatClasification::select(['id', 'name'])->where('erased', '=', 0);

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
            $data = CatClasification::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $medicine = new CatClasification();
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
        $cat = CatClasification::find($id);
        return response()->json(['cat' => $cat]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            try {

                $cat = CatClasification::find($id);
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
        $cat = CatClasification::find($id);
        $cat->erased = 1;
        $cat->save();
        return response()->json("sucess");
    }
}
