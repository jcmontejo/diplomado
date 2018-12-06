<?php

namespace App\Http\Controllers;

use App\Debt;
use App\Diplomat;
use App\Document;
use App\Generation;
use App\Http\Requests\DocumentAddStore;
use App\Http\Requests\StoreStudent;
use App\Payment;
use App\Student;
use App\StudentInscription;
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
        return view('students.index', compact('generations', 'diplomats'));
    }

    public function dataStudents()
    {
        $students = Student::select(['id', 'name', 'last_name', 'mother_last_name', 'birthdate', 'sex', 'phone', 'address', 'email', 'profession', 'documents', 'created_at']);

        return Datatables::of($students)
            ->addColumn('status', function ($student) {
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
            ->addColumn('action', function ($student) {
                $id = $student->id;

                if ($student->documents) {
                    return '<td><div class="btn-group" role="group" aria-label="Basic example">
                    <button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                 <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button>
                 <button class="btn btn-rounded btn-xs btn-success mb-3" value="' . $id . '" OnClick="Documents(this);" data-toggle="modal" data-target="#modalDocuments"><i class="fa fa-eye"></i> Documentos</button>
                 <button class="btn btn-rounded btn-xs btn-warning mb-3" value="' . $id . '" OnClick="inscriptionStudent(this);" data-toggle="modal" data-target="#modalInscription"><i class="fa fa-pencil"></i> Inscribir</button>
                 </div>
                 </td>';
                } else {
                    return '<td><div class="btn-group" role="group" aria-label="Basic example"><button value="' . $id . '" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> Editar</button>
                <button class="btn btn-rounded btn-xs btn-danger mb-3" value="' . $id . '" OnClick="Delete(this);"><i class="fa fa-trash"></i> Eliminar</button></td>
                <button class="btn btn-rounded btn-xs btn-primary mb-3" value="' . $id . '" OnClick="addDocuments(this);" data-toggle="modal" data-target="#modalAddDocuments"><i class="fa fa-plus"></i> Agregar Documentos</button>
                <button class="btn btn-rounded btn-xs btn-warning mb-3" value="' . $id . '" OnClick="inscriptionStudent(this);" data-toggle="modal" data-target="#modalInscription"><i class="fa fa-pencil"></i> Inscribir</button>
                </div>
                </td>';
                }
            })
            ->make(true);
    }

    public function store(StoreStudent $request)
    {
        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                $validated = $request->validated();

                $generation = Generation::find($request->generation_id);
                $diplomat = Diplomat::find($generation->diplomat_id);

                $student = new Student();
                $student->name = $request->name;
                $student->last_name = $request->last_name;
                $student->mother_last_name = $request->mother_last_name;
                $student->birthdate = $request->birthdate;
                $student->sex = $request->sex;
                $student->phone = $request->phone;
                $student->address = $request->address;
                $student->email = $request->email;
                $student->profession = $request->profession;
                $student->save();

                // Student Inscription
                $inscription = new StudentInscription();
                $inscription->student_id = $student->id;
                $inscription->diplomat_id = $generation->diplomat_id;
                $inscription->generation_id = $generation->id;
                $inscription->save();

                $generation->number_students = $generation->number_students + 1;
                $generation->save();

                // Add Debt and Payments to student
                $date = new Carbon($generation->start_date);
                $amount = ($diplomat->cost / $generation->number_payments);

                $debt = new Debt();
                $debt->amount = $diplomat->cost;
                $debt->student_id = $student->id;
                $debt->generation_id = $inscription->id;
                $debt->save();

                for ($i = 1; $i <= $generation->number_payments; $i++) {
                    $date = $date->addWeeks(2);
                    if ($date->dayOfWeek === Carbon::SUNDAY) {
                        $date->addDay();
                    }
                    $datePayment[$i] = $date->toDateString();

                    $payment = new Payment();
                    $payment->concept = 'COLEGIATURA';
                    $payment->date = $datePayment[$i];
                    $payment->amount_payable = $amount;
                    $payment->student_id = $student->id;
                    $payment->generation_id = $generation->id;
                    $payment->diplomat_id = $diplomat->id;
                    $payment->status = 'PENDIENTE';
                    $payment->debt_id = $debt->id;
                    $payment->save();
                }

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

    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update(StoreStudent $request, $id)
    {
        $student = Student::find($id);
        $student->fill($request->all());
        $student->save();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        Student::find($id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!',
        ]);
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
                // $validated = $request->validated();
                $student = Student::find($request->student_id);
                $generation = Generation::find($request->generation_id);
                $diplomat = Diplomat::find($generation->diplomat_id);

                // Student Inscription
                $inscription = new StudentInscription();
                $inscription->student_id = $student->id;
                $inscription->diplomat_id = $generation->diplomat_id;
                $inscription->generation_id = $generation->id;
                $inscription->save();

                $generation->number_students = $generation->number_students + 1;
                $generation->save();

                // Add Debt and Payments to student
                $date = new Carbon($generation->start_date);
                $amount = ($diplomat->cost / $generation->number_payments);

                $debt = new Debt();
                $debt->amount = $diplomat->cost;
                $debt->student_id = $student->id;
                $debt->generation_id = $inscription->id;
                $debt->save();

                for ($i = 1; $i <= $generation->number_payments; $i++) {
                    $date = $date->addWeeks(2);
                    if ($date->dayOfWeek === Carbon::SUNDAY) {
                        $date->addDay();
                    }
                    $datePayment[$i] = $date->toDateString();

                    $payment = new Payment();
                    $payment->concept = 'COLEGIATURA';
                    $payment->date = $datePayment[$i];
                    $payment->amount_payable = $amount;
                    $payment->student_id = $student->id;
                    $payment->generation_id = $generation->id;
                    $payment->diplomat_id = $diplomat->id;
                    $payment->status = 'PENDIENTE';
                    $payment->debt_id = $debt->id;
                    $payment->save();
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
}
