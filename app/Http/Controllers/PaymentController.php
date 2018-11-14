<?php

namespace App\Http\Controllers;

use App\Diplomat;
use App\AccountType;
use DB;

class PaymentController extends Controller
{
    public function processPayment()
    {
        $diplomats = Diplomat::all();
        $types = AccountType::all();
        return view('payments.process', compact('diplomats','types'));
    }

    public function listGenerations($id)
    {
        $generations = DB::table("generations")
            ->where("diplomat_id", $id)
            ->pluck("number_generation", "id");
        return json_encode($generations);
    }

    public function listStudents($id)
    {
        $students = DB::table('student_inscriptions')
            ->join('students', 'student_inscriptions.student_id', '=', 'students.id')
            ->where('student_inscriptions.generation_id', '=', $id)
            ->select(DB::raw("CONCAT(students.name,' ',students.last_name,' ',students.mother_last_name ) AS name, student_inscriptions.id"))
            ->pluck('name', 'id');

        return json_encode($students);
    }
}
