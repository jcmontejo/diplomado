<?php

namespace App\Http\Controllers\Admon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Account;
use App\AccountType;
use App\Debt;
use App\Diplomat;
use App\Document;
use App\Generation;
use App\Http\Requests\DocumentAddStore;
use App\Http\Requests\EditStudent;
use App\Http\Requests\StoreStudent;
use App\Incentive;
use App\Notifications\NEWInscription;
use App\Payment;
use App\PaymentMethod;
use App\PaymentReceived;
use App\Student;
use App\StudentInscription;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Yajra\Datatables\Datatables;


class StudentController extends Controller
{
    public function index(Request $request)
    {
        $generations = Generation::all();
        $diplomats = Diplomat::all();
        $accounts = Account::all();
        $methods = PaymentMethod::all();
        $account_types = AccountType::all();

        return view('admon.students.index', compact('generations', 'diplomats', 'accounts', 'methods', 'account_types'));
    }

    public function dataStudents()
    {
        $students = Student::where('status', '=', 1)->select(['id', 'curp', 'enrollment', 'name', 'last_name', 'mother_last_name', 'birthdate', 'sex', 'phone', 'address', 'email', 'profession', 'documents', 'user_id', 'created_at']);

        return Datatables::of($students)
            ->addColumn('action', function ($student) {
                return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <a href="/admon/alumnos/expediente/'.$student->id.'" target="_blank" class="btn btn-success"><i class="fa fa-eye"></i> Expediente</a>
                <button class="btn btn-primary btn-flat" value="' . $student->id . '" OnClick="Show(this);" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-danger btn-flat" value="' . $student->id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button>
                </div>
                </td>';
            })
            ->make(true);
    }

    public function proceedings($id)
    {   
        $student = Student::find($id);
        $inscriptions = StudentInscription::where('student_inscriptions.student_id', '=', $student->id)
            ->join('diplomats', 'diplomats.id', 'student_inscriptions.diplomat_id')
            ->join('generations', 'generations.id', '=', 'student_inscriptions.generation_id')
            ->join('debts', 'debts.generation_id', '=', 'student_inscriptions.id')
            ->select(
                'diplomats.name as diplomat',
                'generations.number_generation as generation',
                'student_inscriptions.created_at as created_at',
                'student_inscriptions.final_cost as final_cost',
                'debts.id as debt_id',
                'debts.amount as amount'
            )
            ->get();
        return view('admon.students.timeline', compact('student', 'inscriptions'));
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update(EditStudent $request, $id)
    {
        try {
            DB::beginTransaction();
            $student = Student::find($id);
            $student->curp = $request->curp;
            $student->name = $request->name;
            $student->last_name = $request->last_name;
            $student->mother_last_name = $request->mother_last_name;
            $student->facebook = $request->facebook;
            $student->birthdate = $request->birthdate;
            $student->sex = $request->sex;
            $student->phone = $request->phone;
            $student->address = $request->address;
            $student->state = $request->state;
            $student->city = $request->city;
            $student->email = $request->email;
            $student->profession = $request->profession;
            $student->save();
            DB::commit();

            return response()->json([
                "message" => "success",
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    public function if_exist_student($curp)
    {
        $student = DB::table('students')
            ->where('curp', '=', $curp)
            ->first();

        if ($student) {
            return true;
        } else {
            return false;
        }
    }

    public function is_mx_state($state)
    {
        $mxStates = [
            'AS', 'BS', 'CL', 'CS', 'DF', 'GT',
            'HG', 'MC', 'MS', 'NL', 'PL', 'QR',
            'SL', 'TC', 'TL', 'YN', 'NE', 'BC',
            'CC', 'CM', 'CH', 'DG', 'GR', 'JC',
            'MN', 'NT', 'OC', 'QT', 'SP', 'SR',
            'TS', 'VZ', 'ZS',
        ];
        if (in_array(strtoupper($state), $mxStates)) {
            return true;
        }
        return false;
    }

    public function is_sexo_curp($sexo)
    {
        $sexoCurp = ['H', 'M'];
        if (in_array(strtoupper($sexo), $sexoCurp)) {
            return true;
        }
        return false;
    }

    public function checkStudent($id)
    {
        $student = Student::find($id);
        if ($student->curp == '' or $student->name == '' or $student->last_name == '' or $student->mother_last_name == '' or $student->facebook == '' or $student->interested == '' or $student->birthdate == '' or $student->sex == '' or $student->phone == '' or $student->state == 'null' or $student->city == 'null' or $student->address == '' or $student->email == '' or $student->profession == 'null') {
            return false;
        } else {
            return true;
        }
    }
}
