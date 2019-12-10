<?php

namespace App\Http\Controllers\Clinic;

use App\Appoinment;
use App\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;
use App\Http\Requests\StoreAppoinment;
use Yajra\Datatables\Datatables;
use DB;

class AppoinmentController extends Controller
{
    public function index(Request $request)
    {
        $doctors = Doctor::all();
        $rooms = Room::all();
        return view('clinic.appoinments.index', compact('doctors', 'rooms'));
    }

    public function calendar()
    {
        $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
        $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

        $data = Appoinment::join('doctors', 'appoinments.doctor_id', '=', 'doctors.id')
            ->select('appoinments.id as id', DB::raw("CONCAT('Paciente: ',appoinments.patient,' Terapeuta: ', doctors.name) as title"), 'appoinments.start as start', 'appoinments.end as end')
            ->get();

        return response()->json($data);
    }

    public function dataTeachers()
    {
        $appoinments = Appoinment::join('rooms', 'appoinments.room_id', '=', 'rooms.id')
            ->join('doctors', 'appoinments.doctor_id', '=', 'doctors.id')
            //->where('appoinments.status', '=', 1)
            ->select(['appoinments.id as id', 'appoinments.date as date', 'appoinments.start as start', 'appoinments.end as end', 'appoinments.patient as patient', 'appoinments.observation as observation', 'rooms.name as room', 'appoinments.status as status', DB::raw("CONCAT(doctors.name,' ', doctors.lastname) as doctor")]);

        return Datatables::of($appoinments)
            ->addColumn('action', function ($appoinment) {
                $id = $appoinment->id;
                $status = $appoinment->status;
                if ($status == 1) {
                    return '<td>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-minus-circle"></i> Cancelar</button></div></td>';
                } else {
                    return '';
                }
            })
            ->make(true);
    }

    public function store(StoreAppoinment $request)
    {
        if ($request->ajax()) {

            $combinedDT1 = date('Y-m-d H:i:s', strtotime("$request->date $request->start"));
            $combinedDT2 = date('Y-m-d H:i:s', strtotime("$request->date $request->end"));

            $validated = $request->validated();
            $appoinment = new Appoinment();
            $appoinment->date = $request->date;
            $appoinment->start = $combinedDT1;
            $appoinment->end = $combinedDT2;
            $appoinment->patient = $request->patient;
            $appoinment->observation = $request->observation;
            $appoinment->status = $request->status;
            $appoinment->room_id = $request->room_id;
            $appoinment->doctor_id = $request->doctor_id;
            $appoinment->status = 1;
            $appoinment->save();

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function edit($id)
    {
        $appoinment = Appoinment::find($id);
        return response()->json($appoinment);
    }

    public function update(StoreAppoinment $request, $id)
    {
        $appoinment = Appoinment::find($id);
        $appoinment->fill($request->all());
        $appoinment->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        $appoinment = Appoinment::find($id);
        $appoinment->status = 0;
        $appoinment->save();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
    }
}
