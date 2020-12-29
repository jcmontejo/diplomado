<?php

namespace App\Http\Controllers;

use App\CatApplyPayDocent;
use App\CatScheme;
use App\Generation;
use App\StudentInscription;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

class CatPaymentDocentController extends Controller
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
        return view('admon.payments.index');
    }

    public function data()
    {
        $cats = Generation::join('diplomats', 'generations.diplomat_id', '=', 'diplomats.id')
            ->join('teachers', 'generations.docent_id', '=', 'teachers.id')
            ->select(
                'generations.id as id',
                'diplomats.name as diplomat',
                'generations.number_generation as generation',
                'generations.start_date  as start_date',
                //'teachers.name as teacher',
                DB::raw('CONCAT(teachers.name , teachers.last_name , teachers.mother_last_name) AS teacher')
            )->get();

        return Datatables::of($cats)
            ->addColumn('action', function ($cat) {
                return '<div class="btn-group">
          <button type="button" class="btn btn-primary" value="' . $cat->id . '" onClick="editCat(' . $cat->id . ');" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i>
          </button>
          </div>';
            })
            ->make(true);
    }

    public function dataPays($id)
    {
        $cats = CatApplyPayDocent::where('generation_id', '=', $id)->get();

        return Datatables::of($cats)
            ->make(true);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $cat = new CatScheme();
                $cat->type_scheme = $request->type_scheme;
                $cat->cost_student = $request->cost_student;
                $cat->cost_week = $request->cost_week;
                $cat->weeks = $request->weeks;
                $cat->generation_id = $request->generation_id;
                $cat->save();

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }

    public function storeApply(Request $request)
    {
        if ($request->ajax()) {
            try {
                $cat = new CatApplyPayDocent();
                $cat->date = $request->date;
                $cat->amount = $request->amount;
                $cat->generation_id = $request->generation_id;
                $cat->save();

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }

    public function get($id)
    {
        //$cat = Generation::find($id);
        $cat = Generation::join('diplomats', 'generations.diplomat_id', '=', 'diplomats.id')
            ->join('teachers', 'generations.docent_id', '=', 'teachers.id')
            ->select(
                'generations.id as id',
                'diplomats.name as diplomat',
                'generations.number_generation as generation',
                'generations.start_date  as start_date',
                //'teachers.name as teacher',
                DB::raw('CONCAT(teachers.name , teachers.last_name , teachers.mother_last_name) AS teacher')
            )
            ->where('generations.id', '=', $id)->first();
        
        $total_ins = \DB::table('student_inscriptions')->where('generation_id', '=', $id)->count();
        $total_down = \DB::table('student_inscriptions')->where('generation_id', '=', $id)->where('status', '=', 'Baja')->count();
        $rest = $total_ins - $total_down;

        return response()->json(['cat' => $cat, 'total_ins' => $total_ins, 'total_down' => $total_down, 'rest' => $rest]);
    }

    public function getScheme($id)
    {
        $scheme = CatScheme::where('generation_id', '=', $id)->first();

        if ($scheme) {
            return response()->json(["exist" => 1, "scheme" => $scheme]);
        } else {
            return response()->json(["exist" => 0]);
        }
        
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            try {

                $cat = CatExpense::find($id);
                $cat->date = $request->date;
                $cat->amount = $request->amount;
                $cat->concept = $request->concept;
                $cat->account_id = $request->account_id;
                $cat->cat_reference = $request->cat_reference;
                $cat->cat_clasification = $request->cat_clasification;
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
        $cat->delete();

        return response()->json("sucess");
    }
}
