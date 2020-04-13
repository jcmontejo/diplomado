<?php

namespace App\Http\Controllers\Admon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Diplomat;
use App\Http\Requests\StoreDiplomat;
use Yajra\Datatables\Datatables;

class DiplomatController extends Controller
{
    public function index(Request $request)
    {
        return view('admon.diplomats.index');
    }
    
    public function dataDiplomats()
    {
        $diplomats = Diplomat::select(['id', 'name', 'key', 'cost', 'maximum_cost']);

        return Datatables::of($diplomats)
            ->addColumn('action', function ($diplomat) {
                $id = $diplomat->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" OnClick="DeleteMod('.$id.');" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('admon.diplomats.create');
    }

    public function store(StoreDiplomat $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            Diplomat::create($request->all());

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $diplomat = Diplomat::find($id);
        return response()->json($diplomat);
    }

    public function update(StoreDiplomat $request, $id)
    {
        $diplomat = Diplomat::find($id);
        $diplomat->fill($request->all());
        $diplomat->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy(Request $request)
    {
        Diplomat::find($request->id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
