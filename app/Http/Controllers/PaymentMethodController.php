<?php

namespace App\Http\Controllers;
use App\PaymentMethod;
use App\Http\Requests\StorePaymentMethod;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        return view('payment_methods.index');
    }

    public function dataMethods()
    {
        $methods = PaymentMethod::select(['id', 'name']);

        return Datatables::of($methods)
            ->addColumn('action', function ($method) {
                $id = $method->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('payment_methods.create');
    }

    public function store(StorePaymentMethod $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            PaymentMethod::create($request->all());

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $method = PaymentMethod::find($id);
        return response()->json($method);
    }

    public function update(StorePaymentMethod $request, $id)
    {
        $method = PaymentMethod::find($id);
        $method->fill($request->all());
        $method->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        PaymentMethod::find($id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
