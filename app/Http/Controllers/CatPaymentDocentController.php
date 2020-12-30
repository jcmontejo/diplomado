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
            ->addColumn('action', function ($cat) {
                if ($cat->status == 1) {
                    return '<div class="btn-group">
                <button type="button" class="btn btn-primary" value="' . $cat->id . '" onClick="editCatPaidOut(' . $cat->id . ');" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-money-bill"></i>
                </button>
                </div>';
                } else {
                    return '---';
                }
            })
            ->make(true);
    }

    //here
    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $cat = new CatScheme();
                $cat->type_scheme = $request->type_scheme;
                $cat->cost_student = $request->cost_student;
                $cat->cost_week = $request->cost_week;
                $cat->weeks = $request->weeks;
                $cat->number_payments = $request->number_payments;
                $cat->generation_id = $request->generation_id;
                $cat->save();

                if ($cat->type_scheme != 1) {
                    $a = ceil($cat->cost_week * $cat->weeks);
                    $b = ceil($a / $cat->number_payments);

                    for ($i = 0; $i < $cat->number_payments; $i++) {
                        $cat_a = new CatApplyPayDocent();
                        $cat_a->number = $i + 1;
                        $cat_a->amount_expected = $b;
                        $cat_a->amount_paid_out = 0;
                        $cat_a->rest = $a - $cat_a->amount_paid_out;
                        $cat_a->generation_id = $cat->generation_id;
                        $cat_a->save();
                    }
                } else {
                    $a = ceil($cat->cost_student * $request->total_students);
                    $b = ceil($a / $request->number_payments);

                    for ($i = 0; $i < $request->number_payments; $i++) {
                        $cat_a = new CatApplyPayDocent();
                        $cat_a->number = $i + 1;
                        $cat_a->amount_expected = $b;
                        $cat_a->amount_paid_out = 0;
                        $cat_a->rest = $a - $cat_a->amount_paid_out;
                        $cat_a->generation_id = $cat->generation_id;
                        $cat_a->save();
                    }
                }

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
                $scheme = CatScheme::find($request->scheme);
                if ($scheme->type_scheme == 1) {

                    $a = ceil($scheme->cost_student * $request->total_students);
                    $b = ceil($a / $scheme->number_payments);

                    $cat = CatApplyPayDocent::find($request->id);
                    $cat->date = $request->date;
                    $cat->amount_paid_out = $request->amount;
                    //$cat->rest = $a - $cat->amount_paid_out;
                    $cat->status = 0;
                    $cat->generation_id = $request->generation_id;
                    $cat->save();

                    $applys = CatApplyPayDocent::where('generation_id', '=', $request->generation_id)->where('status', '=', 0)->get();
                    $sum_applys = ceil($applys->sum('amount_paid_out'));
                    $count_applys = count($applys);
                    $rest_paids = $scheme->number_payments - $count_applys;
                    $rest_amount = ceil($a - $sum_applys);
                    if ($rest_paids != 0) {
                        $divider = ceil($rest_amount / $rest_paids);
                    } else {
                        $divider = 0;
                    }

                    //here apply paid only
                    if ($rest_paids <= 0) {
                        $cat->rest = 0;
                        $cat->save();
                    } else {
                        $cat->rest = $a - $sum_applys;
                        $cat->save();
                    }


                    $no_applys = CatApplyPayDocent::where('generation_id', '=', $request->generation_id)->where('status', '=', 1)->get();
                    if ($no_applys) {
                        foreach ($no_applys as $key => $value) {
                            $value->amount_expected = $divider;
                            $value->amount_paid_out = 0;
                            $value->rest = $rest_amount;
                            $value->save();
                        }
                    }
                } else {

                    $a = ceil($scheme->cost_week * $scheme->weeks);
                    $b = ceil($a / $scheme->number_payments);

                    $cat = CatApplyPayDocent::find($request->id);
                    $cat->date = $request->date;
                    $cat->amount_paid_out = $request->amount;
                    //$cat->rest = $a - $cat->amount_paid_out;
                    $cat->status = 0;
                    $cat->generation_id = $request->generation_id;
                    $cat->save();

                    $applys = CatApplyPayDocent::where('generation_id', '=', $request->generation_id)->where('status', '=', 0)->get();
                    $sum_applys = ceil($applys->sum('amount_paid_out'));
                    $count_applys = count($applys);
                    $rest_paids = $scheme->number_payments - $count_applys;
                    $rest_amount = ceil($a - $sum_applys);
                    if ($rest_paids != 0) {
                        $divider = ceil($rest_amount / $rest_paids);
                    } else {
                        $divider = 0;
                    }

                    //here apply paid only
                    if ($rest_paids <= 0) {
                        $cat->rest = 0;
                        $cat->save();
                    } else {
                        $cat->rest = $a - $sum_applys;
                        $cat->save();
                    }


                    $no_applys = CatApplyPayDocent::where('generation_id', '=', $request->generation_id)->where('status', '=', 1)->get();
                    if ($no_applys) {
                        foreach ($no_applys as $key => $value) {
                            $value->amount_expected = $divider;
                            $value->amount_paid_out = 0;
                            $value->rest = $rest_amount;
                            $value->save();
                        }
                    }
                }

                return response()->json($sum_applys);
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
                $cat = CatScheme::find($id);
                $cat->type_scheme = $request->type_scheme;
                $cat->cost_student = $request->cost_student;
                $cat->cost_week = $request->cost_week;
                $cat->weeks = $request->weeks;
                $cat->number_payments = $request->number_payments;
                $cat->generation_id = $request->generation_id;
                $cat->save();

                $paids_old = CatApplyPayDocent::where('generation_id', '=', $request->generation_id)->delete();

                if ($cat->type_scheme != 1) {
                    $a = ceil($cat->cost_week * $cat->weeks);
                    $b = ceil($a / $cat->number_payments);

                    for ($i = 0; $i < $cat->number_payments; $i++) {
                        $cat_a = new CatApplyPayDocent();
                        $cat_a->number = $i + 1;
                        $cat_a->amount_expected = $b;
                        $cat_a->amount_paid_out = 0;
                        $cat_a->rest = $a - $cat_a->amount_paid_out;
                        $cat_a->generation_id = $cat->generation_id;
                        $cat_a->save();
                    }
                } else {
                    $a = ceil($cat->cost_student * $request->total_students);
                    $b = ceil($a / $request->number_payments);

                    for ($i = 0; $i < $request->number_payments; $i++) {
                        $cat_a = new CatApplyPayDocent();
                        $cat_a->number = $i + 1;
                        $cat_a->amount_expected = $b;
                        $cat_a->amount_paid_out = 0;
                        $cat_a->rest = $a - $cat_a->amount_paid_out;
                        $cat_a->generation_id = $cat->generation_id;
                        $cat_a->save();
                    }
                }

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }

    public function verifyAmount(Request $request)
    {
        if ($cat->type_scheme != 1) {
            $a = ceil($cat->cost_week * $cat->weeks);
            $b = ceil($a / $cat->number_payments);
        } else {
            $a = ceil($cat->cost_student * $request->total_students);
            $b = ceil($a / $request->number_payments);
        }
    }
}
