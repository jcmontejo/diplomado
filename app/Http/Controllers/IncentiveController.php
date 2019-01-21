<?php

namespace App\Http\Controllers;

use App\Diplomat;
use App\Generation;
use App\Incentive;
use App\Student;
use App\StudentInscription;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class IncentiveController extends Controller
{
    public function index(Request $request)
    {
        return view('incentives.index');
    }

    public function data()
    {
        $incentives = DB::table('incentives')
            ->join('users', 'incentives.user_id', '=', 'users.id')
            ->select('incentives.id as id', 'commission', 'full_price', 'status', 'users.name as employe', 'student_inscription_id')->get();

        return Datatables::of($incentives)
            ->addColumn('details', function ($incentive) {
                $id = $incentive->student_inscription_id;
                $inscription = StudentInscription::find($id);
                $diplomat = Diplomat::find($inscription->diplomat_id);
                $generation = Generation::find($inscription->generation_id);
                $student = Student::find($inscription->student_id);

                return $diplomat->name . '/' . $generation->number_generation . '/' . $student->name . ' ' . $student->last_name . ' ' . $student->mother_last_name . '/' . $inscription->created_at;
            })
            ->addColumn('action', function ($incentive) {
                $id = $incentive->id;
                if ($incentive->status == 'pendiente') {
                    return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Pay(this);" class="btn btn-rounded btn-xs btn-success mb-3"><i class="fa fa-money"></i> Pagar</button></td>';
                }
            })
            ->setRowClass(function ($incentive) {
                //return $student->color == 'red' ? 'bg-danger' : 'bg-warning';
                if ($incentive->status == 'pendiente') {
                    return 'bg-danger';
                }else {
                    return 'bg-success';
                }
            })
            ->make(true);
    }

    public function pay(Request $request, $id)
    {
        $incentive = Incentive::find($id);
        $incentive->status = 'pagado';
        $incentive->save();
        return response()->json(["message" => "success"]);
    }
}
