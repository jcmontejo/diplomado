<?php

namespace App\Http\Controllers;

use App\Seminario;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class SeminarioController extends Controller
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
        return view('admon.seminarios.index');
    }

    public function data()
    {
        $rows = Seminario::select(['id', 'nombre', 'clave', 'precio_venta']);

        return Datatables::of($rows)
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
            $data = Seminario::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $row = new Seminario();
                $row->nombre = $request->nombre;
                $row->clave = $request->clave;
                $row->precio_venta = $request->precio_venta;
                $row->save();

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }

    public function get($id)
    {
        $cat = Seminario::find($id);
        return response()->json(['cat' => $cat]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            try {

                $cat = Seminario::find($id);
                $cat->nombre = $request->nombre;
                $cat->clave = $request->clave;
                $cat->precio_venta = $request->precio_venta;
                $cat->save();

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }
    
    public function delete($id)
    {
        $cat = Seminario::find($id);
        $cat->delete();
        return response()->json("sucess");
    }
}
