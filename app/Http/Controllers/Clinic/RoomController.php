<?php

namespace App\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;
use App\Http\Requests\StoreRoom;
use Yajra\Datatables\Datatables;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        return view('clinic.rooms.index');
    }

    public function dataTeachers()
    {
        $rooms = Room::where('status', '=', 1)->select(['id', 'name', 'price']);

        return Datatables::of($rooms)
            ->addColumn('action', function ($room) {
                $id = $room->id;
                return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></div></td>';
            })
            ->make(true);
    }

    public function store(StoreRoom $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();
            Room::create($request->all());

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $room = Room::find($id);
        return response()->json($room);
    }

    public function update(StoreRoom $request, $id)
    {
        $room = Room::find($id);
        $room->fill($request->all());
        $room->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        $room->status = 0;
        $room->save();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
