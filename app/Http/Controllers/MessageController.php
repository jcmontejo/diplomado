<?php

namespace App\Http\Controllers;

use App\Mail\SendMailable;
use App\Message;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;

class MessageController extends Controller
{
    public function create()
    {
        $students = Student::all();
        return view('messages.create', compact('students'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $text = $request->message;
                $student = Student::find($request->student_id);

                Mail::to($student->email)->send(new SendMailable($text));
                $send = new Message();
                $send->subject = 'null';
                $send->message = $text;
                $send->receiver = $student->name.' '.$student->last_name.' '.$student->mother_last_name;
                $send->receiver_id = $student->id;
                $send->user_id = Auth::user()->id;
                $send->save(); 

                return response()->json([
                    "message" => "success",
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => "error",
                ]);
            }
        }
    }
}
