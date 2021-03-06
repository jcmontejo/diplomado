<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Account;
use App\AccountType;
use App\Debt;
use App\DeudaSeminario;
use App\Diplomat;
use App\Document;
use App\Generation;
use App\GrupoSeminario;
use App\Http\Requests\DocumentAddStore;
use App\Http\Requests\EditStudent;
use App\Http\Requests\StoreStudent;
use App\Incentive;
use App\InscripcionSeminarioGrupo;
use App\Notifications\NEWInscription;
use App\PagoSeminario;
use App\Payment;
use App\PaymentMethod;
use App\PaymentReceived;
use App\Seminario;
use App\Student;
use App\StudentInscription;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
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
        $seminarios = Seminario::all();
        $grupos = GrupoSeminario::all();

        return view('sales.students.index', compact('generations', 'diplomats', 'accounts', 'methods', 'account_types', 'seminarios', 'grupos'));
    }

    public function prospects(Request $request)
    {
        $generations = Generation::all();
        $diplomats = Diplomat::all();
        $accounts = Account::all();
        $methods = PaymentMethod::all();
        $account_types = AccountType::all();

        return view('students.prospects', compact('generations', 'diplomats', 'accounts', 'methods', 'account_types'));
    }

    public function dataProspects()
    {
        $user = Auth::user();
        if ($user->hasRole('Vendedor')) {
            $students = Student::select(['id', 'color', 'enrollment', 'curp', 'name', 'last_name', 'mother_last_name', 'facebook', 'interested', 'status', 'birthdate', 'sex', 'phone', 'state', 'city', 'address', 'email', 'profession', 'documents', 'keep_going', 'status', 'user_id', 'created_at'])
                ->where([
                    ['user_id', '=', $user->id],
                    ['status', '!=', '1'],
                    ['keep_going', '=', '1'],
                ])->get();
        } else {
            $students = Student::select(['id', 'color', 'enrollment', 'curp', 'name', 'last_name', 'mother_last_name', 'facebook', 'interested', 'status', 'birthdate', 'sex', 'phone', 'state', 'city', 'address', 'email', 'profession', 'documents', 'status', 'user_id', 'created_at'])
                ->where([
                    ['status', '!=', '1'],
                    ['keep_going', '=', '1'],
                ])->get();
        }

        return Datatables::of($students)
            ->addColumn('owner', function ($student) {
                $id = $student->user_id;

                $user = User::find($id);

                return $user->name;
            })
            ->addColumn('action', function ($student) {

                if (Auth::user()->hasRole('Vendedor')) {
                    $id = $student->id;
                    if ($student->status >= 100) {
                        return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button></td>
                    <button class="btn btn-rounded btn-xs btn-secondary mb-3" value="' . $id . '" OnClick="inscriptionStudent(this);" data-toggle="modal" data-target="#modalInscription"><i class="fa fa-pencil"></i> Inscribir</button>
                    <button class="btn btn-rounded btn-xs btn-dark mb-3" value="' . $id . '" OnClick="downStudent(this);"><i class="fa fa-trash"></i>Descartar</button>
                    </div>
                    </td>';
                    } elseif ($student->keep_going === 1) {
                        return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button></td>
                    <button class="btn btn-rounded btn-xs btn-default mb-3" value="' . $id . '" OnClick="trafficStudent(this);" data-toggle="modal" data-target="#modalTraffic"><i class="fa fa-wrench"></i> Modificar Semaforo</button>
                    <button class="btn btn-rounded btn-xs btn-dark mb-3" value="' . $id . '" OnClick="downStudent(this);"><i class="fa fa-trash"></i>Descartar</button>
                    </div>
                    </td>';
                    } else {
                        return '<td>
                    <h4>PROSPECTO DESCARTADO</h4>
                    </td>';
                    }
                } else {
                    return '<td>
                    <h4>---</h4>
                    </td>';
                }
            })
            ->setRowClass(function ($student) {
                //return $student->color == 'red' ? 'bg-danger' : 'bg-warning';
                if ($student->color == 'red') {
                    return 'bg-danger';
                } elseif ($student->color == 'yellow') {
                    return 'bg-warning';
                } else {
                    return 'bg-success';
                }
            })
            ->make(true);
    }


    public function dataStudents()
    {
        $user = Auth::user();
        if ($user->hasRole('Vendedor')) {
            $students = Student::where([
                //['user_id', '=', $user->id],
                ['status', '=', '1'],
            ])->select(['id', 'curp', 'enrollment', 'name', 'last_name', 'mother_last_name', 'birthdate', 'sex', 'phone', 'address', 'email', 'profession', 'documents', 'user_id', 'created_at']);
        } else {
            $students = Student::where('status', '=', 1)->select(['id', 'curp', 'enrollment', 'name', 'last_name', 'mother_last_name', 'birthdate', 'sex', 'phone', 'address', 'email', 'profession', 'documents', 'user_id', 'created_at']);
        }

        return Datatables::of($students)
            ->addColumn('now', function ($student) {
                $id = $student->id;

                $debts = DB::table('debts')->where([
                    ['status', '=', 'ACTIVA'],
                    ['student_id', '=', $id],
                ])->count();

                if ($debts) {
                    return 'ACTIVO';
                } else {
                    return 'INACTIVO';
                }
            })
            ->addColumn('owner', function ($student) {
                $id = $student->user_id;

                $user = User::find($id);

                return $user->name;
            })
            ->addColumn('action', function ($student) {
                $id = $student->id;
                $userNow = Auth::user();

                if ($userNow->hasRole('Vendedor')) {
                    return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <button class="btn btn-success" value="' . $id . '" OnClick="inscriptionStudent(this);" data-toggle="modal" data-target="#modalInscription"><i class="fas fa-plus"></i> DIPLOMADO</button>
                <button class="btn btn-primary" value="' . $id . '" OnClick="inscriptionStudentSeminario(this);" data-toggle="modal" data-target="#modalInscriptionSeminario"><i class="fas fa-plus"></i> SEMINARIO</button>
                </div>
                </td>';
                } elseif ($userNow->hasRole('Administrador')) {
                    return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button>
                <button class="btn btn-rounded btn-xs btn-primary mb-3" value="' . $id . '" OnClick="Show(this);" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                </div>
                </td>';
                } elseif ($userNow->hasRole('Control Escolar')) {
                    return '<td><div class="btn-group" role="group" aria-label="Basic example">
                <button class="btn btn-rounded btn-xs btn-primary mb-3" value="' . $id . '" OnClick="Show(this);" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                </div>
                </td>';
                } else {
                    return '<td><div class="btn-group" role="group" aria-label="Basic example">
                    <button class="btn btn-warning">Sin privilegios</button>
                </td>';
                }
            })
            ->make(true);
    }

    public function detailsPorcent($porcent)
    {
        $user = Auth::user();

        $generations = Generation::all();
        $diplomats = Diplomat::all();
        $accounts = Account::all();
        $methods = PaymentMethod::all();
        $account_types = AccountType::all();

        $students = Student::select(['id', 'color', 'name', 'last_name', 'mother_last_name', 'facebook', 'interested', 'status', 'birthdate', 'sex', 'phone', 'state', 'city', 'address', 'email', 'profession', 'documents', 'status', 'user_id', 'created_at'])
            ->where([
                ['user_id', '=', $user->id],
                ['status', '=', $porcent],
            ])->get();

        return view('students.detail_prospects', compact('students', 'generations', 'diplomats', 'accounts', 'methods', 'account_types'));
    }


    public function checkCurp(Request $request)
    {
        $student = DB::table('students')
            ->where('curp', '=', $request->curp)
            ->first();

        if ($student) {
            return response()->json(array("exists" => true));
        } else {
            return response()->json(array("exists" => false));
        }
    }

    public function checkCurpTwo($crp)
    {
        $student = DB::table('students')
            ->where('curp', '=', $crp)
            ->first();

        if ($student) {
            return response()->json(array("exists" => true, "crp" => $crp));
        } else {
            return response()->json(array("exists" => false));
        }
    }

    public function search($search)
    {
        $student = Student::where('curp', '=', $search)->first();

        if ($student) {
            $inscriptions = StudentInscription::where('student_inscriptions.student_id', '=', $student->id)
                //->where('student_inscriptions.status', '=', 'Baja')
                ->join('diplomats', 'diplomats.id', '=', 'student_inscriptions.diplomat_id')
                ->join('generations', 'generations.id', '=', 'student_inscriptions.generation_id')
                ->leftJoin('debts', 'debts.generation_id', '=', 'student_inscriptions.id')
                ->select(
                    DB::raw('CONCAT(student_inscriptions.number_of_payments," PAGOS DE ",student_inscriptions.amount_of_payments) as observations'),
                    'student_inscriptions.discount as discount',
                    'student_inscriptions.first_payment as first_payment',
                    'student_inscriptions.id as id_inscription',
                    'student_inscriptions.final_cost as final_cost',
                    'student_inscriptions.status as status',
                    'debts.amount as total_debt',
                    'debts.id as debt_id',
                    'diplomats.name as diplomat',
                    'generations.number_generation as generation',
                    'diplomats.id as id_diplomat'
                )->get();
        }

        if ($student) {
            return response()->json([
                'status' => 'ok',
                'data' => $student,
                'inscriptions' => $inscriptions
            ]);
        } else {
            return response()->json([
                'status' => 'no'
            ]);
        }
    }

    public function listGenerations($id)
    {
        $student_inscriptions = DB::table("student_inscriptions")
            ->where('id', '=', $id)
            ->first();

        $flag = DB::table("generations")
            ->where('id', '=', $student_inscriptions->generation_id)
            ->first();

        $generations = DB::table("generations")
            ->where("diplomat_id", $student_inscriptions->diplomat_id)
            ->where('number_generation', '=', $flag->number_generation + 1)
            ->pluck("number_generation", "id");

        return json_encode($generations);
    }

    public function store(StoreStudent $request)
    {
        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                $validated = $request->validated();
                $user = Auth::user();

                $number = Student::max('id') + 1;

                $student = new Student();
                //$student->enrollment = '000000' . $number;
                $student->curp = $request->curp;
                $student->name = $request->name;
                $student->last_name = $request->last_name;
                $student->mother_last_name = $request->mother_last_name;
                $student->facebook = $request->facebook;
                $student->interested = $request->interested;
                $student->birthdate = $request->birthdate;
                $student->sex = $request->sex;
                $student->phone = $request->phone;
                $student->address = $request->address;
                $student->state = $request->state;
                $student->city = $request->city;
                $student->email = $request->email;
                $student->profession = $request->profession;
                $student->status = $request->status;
                if ($student->status <= 30) {
                    $student->color = 'red';
                } elseif ($student->status >= 40 and $student->status <= 80) {
                    $student->color = 'yellow';
                } elseif ($student->status >= 90) {
                    $student->color = 'green';
                }
                $student->user_id = $user->id;
                $student->save();

                $student->enrollment = 'SER00000000' . $student->id;
                $student->save();

                if ($request->hasFile('file_address')) {
                    $extension = $request->file('file_address');
                    $extension = $request->file('file_address')->getClientOriginalExtension(); // getting excel extension
                    $dir = 'assets/files/';
                    $proof_of_address = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
                    $request->file('file_address')->move($dir, $proof_of_address);

                    // Save Document
                    $document = new Document();
                    $document->proof_of_address = $proof_of_address;
                    $document->student_id = $student->id;
                    $document->save();

                    // add document to student
                    $student->documents = 1;
                    $student->save();
                }

                if ($request->hasFile('file_studies')) {
                    $extension_study = $request->file('file_studies');
                    $extension_study = $request->file('file_studies')->getClientOriginalExtension(); // getting excel extension
                    $dir_study = 'assets/files/';
                    $proof_of_studies = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension_study;
                    $request->file('file_studies')->move($dir_study, $proof_of_studies);

                    // Save Document
                    $document->proof_of_studies = $proof_of_studies;
                    $document->save();
                }
                DB::commit();

                return response()->json([
                    "message" => "success",
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function validate_curp($valor)
    {
        if (strlen($valor) == 18) {
            $letras = substr($valor, 0, 4);
            $numeros = substr($valor, 4, 6);
            $sexo = substr($valor, 10, 1);
            $mxState = substr($valor, 11, 2);
            $letras2 = substr($valor, 13, 3);
            $homoclave = substr($valor, 16, 2);
            if (ctype_alpha($letras) && ctype_alpha($letras2) && ctype_digit($numeros) && ctype_digit($homoclave) or ctype_alnum($homoclave) && $this->is_mx_state($mxState) && $this->is_sexo_curp($sexo)) {
                return true;
            }
            return false;
        } else {
            return false;
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

    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update(EditStudent $request, $id)
    {
        try {
            DB::beginTransaction();
            if ($request->ajax()) {

                $student = Student::find($id);

                if ($request->curp) {
                    // if ($this->validate_curp($request->curp)) {
                    if ($student->curp) {
                        $student->curp = $request->curp;
                        $student->name = $request->name;
                        $student->last_name = $request->last_name;
                        $student->mother_last_name = $request->mother_last_name;
                        $student->facebook = $request->facebook;
                        // $student->interested = $request->interested;
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
                    } else {
                        if ($this->if_exist_student($request->curp)) {
                            DB::rollBack();

                            return response()
                                ->json([
                                    'message' => 'Ya existe un registro con la misma CURP.',
                                    'status' => 400,
                                ], 400);
                        } else {
                            $student->curp = $request->curp;
                            $student->name = $request->name;
                            $student->last_name = $request->last_name;
                            $student->mother_last_name = $request->mother_last_name;
                            $student->facebook = $request->facebook;
                            // $student->interested = $request->interested;
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
                        }
                    }
                    // } else {
                    //     DB::rollBack();

                    //     return response()
                    //         ->json([
                    //             'message' => 'CURP incorrecta, verifica.',
                    //             'status' => 500,
                    //         ], 500);
                    // }

                } else {
                    $student->curp = $request->curp;
                    $student->name = $request->name;
                    $student->last_name = $request->last_name;
                    $student->mother_last_name = $request->mother_last_name;
                    $student->facebook = $request->facebook;
                    $student->interested = $request->interested;
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
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function down(Request $request, $id)
    {
        $student = Student::find($id);
        $student->keep_going = '0';
        $student->save();
        return response()->json(["message" => "success"]);
    }

    public function updateStatus(Request $request, $id)
    {
        $student = Student::find($id);
        $student->status = $request->status;
        if ($student->status <= 30) {
            $student->color = 'red';
        } elseif ($student->status >= 40 and $student->status <= 80) {
            $student->color = 'yellow';
        } elseif ($student->status >= 90) {
            $student->color = 'green';
        }
        $student->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $payments = DB::table('payments')
                ->where('student_id', '=', $id)->delete();

            $payment_receiveds = DB::table('payment_receiveds')
                ->where('student_id', '=', $id)->delete();

            $debts = DB::table('debts')
                ->where('student_id', '=', $id)->delete();

            $student_inscriptions = DB::table('student_inscriptions')
                ->select('student_inscriptions.*')
                ->where('student_id', '=', $id);

            // $incentive = DB::table('incentives')
            //     ->where('student_inscription_id', '=', $student_inscriptions->id)->delete();

            $student_inscriptions->delete();

            Student::find($id)->delete();

            DB::commit();

            return response()->json([
                'success' => 'Record has been deleted successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function Documents($id)
    {

        $document = Student::find($id)->document;

        return response()->json($document);
    }

    public function show($id)
    {
        $student = Student::find($id);

        return response()->json($student);
    }

    public function uploadDocuments(DocumentAddStore $request)
    {
        $validated = $request->validated();

        $student = Student::find($request->id);

        if ($request->hasFile('file_address')) {
            $extension = $request->file('file_address');
            $extension = $request->file('file_address')->getClientOriginalExtension(); // getting excel extension
            $dir = 'assets/files/';
            $proof_of_address = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
            $request->file('file_address')->move($dir, $proof_of_address);

            // Save Document
            $document = new Document();
            $document->proof_of_address = $proof_of_address;
            $document->student_id = $student->id;
            $document->save();

            // add document to student
            $student->documents = 1;
            $student->save();
        }

        if ($request->hasFile('file_studies')) {
            $extension_study = $request->file('file_studies');
            $extension_study = $request->file('file_studies')->getClientOriginalExtension(); // getting excel extension
            $dir_study = 'assets/files/';
            $proof_of_studies = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension_study;
            $request->file('file_studies')->move($dir_study, $proof_of_studies);

            // Save Document
            $document->proof_of_studies = $proof_of_studies;
            $document->save();
        }

        return response()->json([
            "message" => "success",
        ]);
    }

    public function searchStudent($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function incscriptionStudent(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->ajax()) {

                $exists = DB::table('student_inscriptions')
                    ->where('student_id', '=', $request->student_id)
                    ->where('generation_id', '=', $request->generation_id)
                    ->where('status', '=', 'Alta')
                    ->first();

                if ($exists) {
                    DB::rollBack();
                    return response()->json(array("exists" => true));
                } else {
                    if ($this->checkStudent($request->student_id)) {
                        $student = Student::find($request->student_id);
                        $student->status = 1;
                        $student->save();

                        $generation = Generation::find($request->generation_id);
                        $diplomat = Diplomat::find($generation->diplomat_id);

                        // Student Inscription
                        $inscription = new StudentInscription();
                        $inscription->student_id = $student->id;
                        $inscription->diplomat_id = $generation->diplomat_id;
                        $inscription->generation_id = $generation->id;
                        $inscription->discount = $request->discount;
                        if (empty($generation->maximum_cost)) {
                            $inscription->final_cost = $diplomat->maximum_cost - $request->discount;
                        } else {
                            $inscription->final_cost = $generation->maximum_cost - $request->discount;
                        }
                        $inscription->number_of_payments = $request->number_payments;
                        $inscription->first_payment = $request->first_payment;
                        $inscription->comments = $request->comments;
                        $inscription->amount_of_payments = $request->amount_of_payments;
                        $inscription->periodicity = $request->periodicity;
                        $inscription->type_of_inscription = $request->type_of_inscription;
                        $inscription->baja = false;
                        $inscription->save();

                        $generation->number_students = $generation->number_students + 1;
                        $generation->save();

                        // Add Debt and Payments to student
                        $date = new Carbon($generation->start_date);
                        $sum_first_payment = $inscription->discount + $inscription->first_payment;
                        $discount = $inscription->final_cost - $inscription->first_payment;

                        //$amount = ($discount / $request->number_payments);

                        $debt = new Debt();
                        if (empty($generation->maximum_cost)) {
                            $debt->amount = $diplomat->maximum_cost - $sum_first_payment;
                        } else {
                            $debt->amount = $generation->maximum_cost - $sum_first_payment;
                        }
                        $debt->student_id = $student->id;
                        $debt->generation_id = $inscription->id;
                        $debt->save();

                        for ($i = 1; $i <= $request->number_payments; $i++) {
                            $date = $date->addWeeks(2);
                            if ($date->dayOfWeek === Carbon::SUNDAY) {
                                $date->addDay();
                            }
                            $datePayment[$i] = $date->toDateString();

                            $payment = new Payment();
                            $payment->concept = 'COLEGIATURA';
                            $payment->number_payment = $i;
                            $payment->date = $datePayment[$i];
                            $payment->amount_paid = 0;
                            $payment->student_id = $student->id;
                            $payment->generation_id = $generation->id;
                            $payment->diplomat_id = $diplomat->id;
                            $payment->status = 'PENDIENTE';
                            $payment->debt_id = $debt->id;
                            $payment->save();
                        }

                        $mytime = Carbon::now();

                        $received = new PaymentReceived();
                        $received->diplomat_id = $diplomat->id;
                        $received->generation_id = $generation->id;
                        $received->student_id = $inscription->student_id;
                        $received->date_payment = $mytime->toDateTimeString();
                        $received->observation = 'NULL';
                        $received->payment_method = $request->payment_method;
                        $received->destination_account = $request->account;
                        $received->account_type = $request->account_type;
                        $received->amount = $inscription->first_payment;
                        $received->discount = 0;
                        $received->total = $inscription->first_payment;
                        $received->type = 0;
                        $received->number_pay = 0;
                        $received->debt_id = $debt->id;
                        $received->save();

                        // $this->received($diplomat->id, $generation->id, $inscription->id, $request->first_payment, $request->account, $request->payment_method, $request->account_type);

                        $this->incentive($inscription->id, $generation->id, $student->id, $inscription->discount);
                        //$inscription->notify(new NEWInscription($inscription));
                        DB::commit();

                        return response()->json([
                            "message" => "success",
                            $sum_first_payment,
                            $discount,
                            $debt,
                        ]);
                    } else {
                        DB::rollBack();

                        return response()
                            ->json([
                                'message' => 'Datos del estudiante no estan completos.',
                                'status' => 400,
                            ], 400);
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function incscriptionStudentSeminario(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                $student = Student::find($request->student_id);

                $this->nSeminario($student->id, $request->seminario_id, $request->grupo_id, $request->descuento, $request->numero_de_pagos, $request->monto_de_pagos, $request->primer_pago, $request->cuenta_destino, $request->tipo_cuota, $request->metodo_de_pago);
                DB::commit();
                return response()->json([
                    "message" => "success",
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function received($diplomat, $generation, $inscription, $first_payment, $account, $method, $type)
    {
        try {
            DB::beginTransaction();

            $diplomat = Diplomat::find($diplomat);
            $generation = Generation::find($generation);
            $inscription = StudentInscription::find($inscription);
            $debt = DB::table('debts')
                ->where('generation_id', '=', $inscription->id)
                ->where('status', '=', 'ACTIVA')
                ->first();

            $mytime = Carbon::now();

            $received = new PaymentReceived();
            $received->diplomat_id = $diplomat->id;
            $received->generation_id = $generation->id;
            $received->student_id = $inscription->student_id;
            $received->date_payment = $mytime->toDateTimeString();
            $received->observation = 'NULL';
            $received->payment_method = $method;
            $received->destination_account = $account;
            $received->account_type = $type;
            $received->amount = $first_payment;
            $received->discount = 0;
            $received->total = $first_payment;
            $received->type = 0;
            $received->debt_id = $debt->id;
            $received->save();

            if ($this->adjustDebt($debt->id, $received->total)) {
                $this->sumAccount($received->destination_account, $received->total);

                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function adjustDebt($debt, $amount)
    {
        $debt = Debt::find($debt);
        if ($amount <= $debt->amount) {
            $debt->amount = $debt->amount - $amount;
            $debt->save();

            if ($debt->amount == 0) {
                $debt->status = 'PAGADA';
                $debt->save();
            }
            return true;
        } else {
            return false;
        }
    }

    public function sumAccount($account, $amount)
    {
        $account = Account::find($account);
        $account->opening_balance = $account->opening_balance + $amount;
        $account->save();

        return true;
    }

    public function incentive($inscriptionID, $generationID, $studentID, $discount)
    {
        $student = Student::find($studentID);
        $generation = Generation::find($generationID);
        $inscription = StudentInscription::find($inscriptionID);

        $incentive = new Incentive();
        if ($inscription->final_cost >= $generation->cost) {
            $incentive->commission = $generation->commision;
        } else {
            $incentive->commission = '0';
        }
        if ($inscription->final_cost >= $generation->cost) {
            $extra = $inscription->final_cost - $generation->cost;
            $porcent = $generation->full_price / 100;
            $incentive->full_price = round($extra * $porcent, 2);
        } else {
            $incentive->full_price = '0';
        }
        $incentive->student_inscription_id = $inscriptionID;
        $incentive->user_id = $student->user_id;
        $incentive->save();

        if ($incentive) {
            return true;
        } else {
            return false;
        }
    }

    public function newInscription($id)
    {
        return 'ok';
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


    public function checkStudentInscription(Request $request)
    {
        $exist = DB::table('student_inscriptions')
            ->where('student_id', '=', $request->student_id)
            ->where('generation_id', '=', $request->generation_re)
            ->where('status', '=', 'Alta')
            ->first();

        if ($exist) {
            return response()->json(array("exists" => true));
        } else {
            return response()->json(array("exists" => false));
        }
    }

    public function incscriptionStudentOld(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                //Data
                $student_inscription = StudentInscription::find($request->old_inscription);
                $student = Student::find($request->student_id);
                $generation = Generation::find($request->generation_re);
                $diplomat = Diplomat::find($generation->diplomat_id);
                //Calculate discount
                $debt = Debt::where('generation_id', '=', $student_inscription->id)->first();
                $discount_new = $student_inscription->final_cost - $debt->amount;

                // Student Inscription
                $inscription = new StudentInscription();
                $inscription->student_id = $student->id;
                $inscription->diplomat_id = $generation->diplomat_id;
                $inscription->generation_id = $generation->id;
                $inscription->discount = $discount_new;
                if (empty($generation->maximum_cost)) {
                    $inscription->final_cost = $diplomat->maximum_cost - $request->discount;
                } else {
                    $inscription->final_cost = $generation->maximum_cost - $request->discount;
                }
                $inscription->number_of_payments = $student_inscription->number_of_payments;
                $inscription->first_payment = 0;
                $inscription->comments = "Recursador";
                $inscription->amount_of_payments = $student_inscription->amount_of_payments;
                $inscription->periodicity = $student_inscription->periodicity;
                $inscription->type_of_inscription = "RECURSADOR";
                $inscription->save();

                $generation->number_students = $generation->number_students + 1;
                $generation->save();

                // Add Debt and Payments to student
                $date = new Carbon($generation->start_date);
                $sum_first_payment = $inscription->discount + $inscription->first_payment;
                $discount = $inscription->final_cost - $inscription->first_payment;

                //$amount = ($discount / $request->number_payments);

                $debt = new Debt();
                if (empty($generation->maximum_cost)) {
                    $debt->amount = $diplomat->maximum_cost - $sum_first_payment;
                } else {
                    $debt->amount = $generation->maximum_cost - $sum_first_payment;
                }
                $debt->student_id = $student->id;
                $debt->generation_id = $inscription->id;
                $debt->save();

                for ($i = 1; $i <= $request->number_payments; $i++) {
                    $date = $date->addWeeks(2);
                    if ($date->dayOfWeek === Carbon::SUNDAY) {
                        $date->addDay();
                    }
                    $datePayment[$i] = $date->toDateString();

                    $payment = new Payment();
                    $payment->concept = 'COLEGIATURA';
                    $payment->number_payment = $i;
                    $payment->date = $datePayment[$i];
                    $payment->amount_paid = 0;
                    $payment->student_id = $student->id;
                    $payment->generation_id = $generation->id;
                    $payment->diplomat_id = $diplomat->id;
                    $payment->status = 'PENDIENTE';
                    $payment->debt_id = $debt->id;
                    $payment->save();
                }

                $mytime = Carbon::now();

                DB::commit();

                return response()->json([
                    'student' => $student,
                    'generation' => $generation,
                    'old_inscription' => $student_inscription
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
    }


    public function nStudent(StoreStudent $request)
    {
        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                $validated = $request->validated();
                $user = Auth::user();

                $number = Student::max('id') + 1;

                $student = new Student();
                $student->enrollment = 'SER00000000' . $number;
                $student->curp = $request->curp;
                $student->name = $request->name;
                $student->last_name = $request->last_name;
                $student->mother_last_name = $request->mother_last_name;
                $student->facebook = $request->facebook;
                $student->interested = 'null';
                $student->birthdate = $request->birthdate;
                $student->sex = $request->sex;
                $student->phone = $request->phone;
                $student->address = $request->address;
                $student->state = $request->state;
                $student->city = $request->city;
                $student->email = $request->email;
                $student->profession = $request->profession;
                $student->status = 100;
                if ($student->status <= 30) {
                    $student->color = 'red';
                } elseif ($student->status >= 40 and $student->status <= 80) {
                    $student->color = 'yellow';
                } elseif ($student->status >= 90) {
                    $student->color = 'green';
                }
                $student->user_id = $user->id;
                $student->save();

                $student->enrollment = 'SER00000000' . $student->id;
                $student->save();


                $this->nInscription($student->id, $request->generation_id, $request->discount, $request->number_payments, $request->amount_of_payments, $request->first_payment, $request->periodicity, $request->account, $request->account_type, $request->payment_method);
                DB::commit();
                return response()->json([
                    "message" => "success",
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function nStudentSeminario(StoreStudent $request)
    {
        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                $validated = $request->validated();
                $user = Auth::user();

                $number = Student::max('id') + 1;

                $student = new Student();
                $student->enrollment = 'SER00000000' . $number;
                $student->curp = $request->curp;
                $student->name = $request->name;
                $student->last_name = $request->last_name;
                $student->mother_last_name = $request->mother_last_name;
                $student->facebook = $request->facebook;
                $student->interested = 'null';
                $student->birthdate = $request->birthdate;
                $student->sex = $request->sex;
                $student->phone = $request->phone;
                $student->address = $request->address;
                $student->state = $request->state;
                $student->city = $request->city;
                $student->email = $request->email;
                $student->profession = $request->profession;
                $student->status = 100;
                if ($student->status <= 30) {
                    $student->color = 'red';
                } elseif ($student->status >= 40 and $student->status <= 80) {
                    $student->color = 'yellow';
                } elseif ($student->status >= 90) {
                    $student->color = 'green';
                }
                $student->user_id = $user->id;
                $student->save();

                $student->enrollment = 'SER00000000' . $student->id;
                $student->save();


                $this->nSeminario($student->id, $request->seminario_id, $request->grupo_id, $request->descuento, $request->numero_de_pagos, $request->monto_de_pagos, $request->primer_pago, $request->cuenta_destino, $request->tipo_cuota, $request->metodo_de_pago);
                DB::commit();
                return response()->json([
                    "message" => "success",
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function nInscription($student_id, $generation_id, $discount, $number_payments, $amount_of_payments, $first_payment, $periodicity, $account, $account_type, $payment_method)
    {
        try {
            DB::beginTransaction();
            if ($this->checkStudent($student_id)) {
                $student = Student::find($student_id);
                $student->status = 1;
                $student->save();

                $generation = Generation::find($generation_id);
                $diplomat = Diplomat::find($generation->diplomat_id);

                // Student Inscription
                $inscription = new StudentInscription();
                $inscription->student_id = $student->id;
                $inscription->diplomat_id = $generation->diplomat_id;
                $inscription->generation_id = $generation->id;
                $inscription->discount = $discount;
                if (empty($generation->maximum_cost)) {
                    $inscription->final_cost = $diplomat->maximum_cost - $discount;
                } else {
                    $inscription->final_cost = $generation->maximum_cost - $discount;
                }
                $inscription->number_of_payments = $number_payments;
                $inscription->first_payment = $first_payment;
                $inscription->comments = 'null';
                $inscription->amount_of_payments = $amount_of_payments;
                $inscription->periodicity = $periodicity;
                $inscription->type_of_inscription = 'NUEVO';
                $inscription->baja = false;
                $inscription->save();

                $generation->number_students = $generation->number_students + 1;
                $generation->save();

                // Add Debt and Payments to student
                $date = new Carbon($generation->start_date);
                $sum_first_payment = $inscription->discount + $inscription->first_payment;
                $discount = $inscription->final_cost - $inscription->first_payment;

                //$amount = ($discount / $request->number_payments);

                $debt = new Debt();
                if (empty($generation->maximum_cost)) {
                    $debt->amount = $diplomat->maximum_cost - $sum_first_payment;
                } else {
                    $debt->amount = $generation->maximum_cost - $sum_first_payment;
                }
                $debt->student_id = $student->id;
                $debt->generation_id = $inscription->id;
                $debt->save();

                for ($i = 1; $i <= $number_payments; $i++) {
                    $date = $date->addWeeks(2);
                    if ($date->dayOfWeek === Carbon::SUNDAY) {
                        $date->addDay();
                    }
                    $datePayment[$i] = $date->toDateString();

                    $payment = new Payment();
                    $payment->concept = 'COLEGIATURA';
                    $payment->number_payment = $i;
                    $payment->date = $datePayment[$i];
                    $payment->amount_paid = 0;
                    $payment->student_id = $student->id;
                    $payment->generation_id = $generation->id;
                    $payment->diplomat_id = $diplomat->id;
                    $payment->status = 'PENDIENTE';
                    $payment->debt_id = $debt->id;
                    $payment->save();
                }

                $mytime = Carbon::now();

                $received = new PaymentReceived();
                $received->diplomat_id = $diplomat->id;
                $received->generation_id = $generation->id;
                $received->student_id = $inscription->student_id;
                $received->date_payment = $mytime->toDateTimeString();
                $received->observation = 'NULL';
                $received->payment_method = $payment_method;
                $received->destination_account = $account;
                $received->account_type = $account_type;
                $received->amount = $inscription->first_payment;
                $received->discount = 0;
                $received->total = $inscription->first_payment;
                $received->type = 0;
                $received->number_pay = 0;
                $received->debt_id = $debt->id;
                $received->save();

                // $this->received($diplomat->id, $generation->id, $inscription->id, $request->first_payment, $request->account, $request->payment_method, $request->account_type);

                $this->incentive($inscription->id, $generation->id, $student->id, $inscription->discount);
                //$inscription->notify(new NEWInscription($inscription));
                DB::commit();

                return true;
            } else {
                DB::rollBack();

                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function nSeminario($student_id, $seminario_id, $grupo_id, $descuento, $numero_de_pagos, $monto_de_pagos, $primer_pago, $cuenta_destino, $tipo_cuota, $metodo_de_pago)
    {
        try {
            DB::beginTransaction();
            if ($this->checkStudent($student_id)) {
                $student = Student::find($student_id);
                $student->status = 1;
                $student->save();

                $grupo = GrupoSeminario::find($grupo_id);
                $seminario = Seminario::find($seminario_id);

                // Student Inscription 
                $inscription = new InscripcionSeminarioGrupo();
                $inscription->descuento = $descuento;
                $inscription->costo_final = $seminario->precio_venta;
                $inscription->primer_pago = $primer_pago;
                $inscription->numero_de_pagos = $numero_de_pagos;
                $inscription->monto_de_pagos = $monto_de_pagos;
                $inscription->comentarios = 'null';
                $inscription->seminario_id = $seminario_id;
                $inscription->grupo_id = $grupo_id;
                $inscription->student_id = $student->id;
                $inscription->metodo_de_pago = $metodo_de_pago;
                $inscription->id_vendedor = Auth::user()->id;
                $inscription->save();


                // Add Debt and Payments to student
                $date = Carbon::now();

                $debt = new DeudaSeminario();
                $debt->monto = $inscription->costo_final - ($descuento + $primer_pago);
                $debt->inscripcion_id = $inscription->id;
                $debt->save();

                for ($i = 1; $i <= $numero_de_pagos; $i++) {
                    $date = $date->addWeeks(2);
                    if ($date->dayOfWeek === Carbon::SUNDAY) {
                        $date->addDay();
                    }
                    $datePayment[$i] = $date->toDateString();

                    $payment = new PagoSeminario();
                    $payment->monto = 0;
                    $payment->fecha_de_pago = $datePayment[$i];
                    $payment->numero_de_pago = $i;
                    $payment->deuda_id = $debt->id;
                    $payment->save();
                }

                $mytime = Carbon::now();

                DB::commit();

                return true;
            } else {
                DB::rollBack();

                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
