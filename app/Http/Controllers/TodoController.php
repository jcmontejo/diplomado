<?php

namespace App\Http\Controllers;

use App\Todo;
use Auth;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $task = new Todo();
            $task->title = $request->title;
            $task->user_id = Auth::user()->id;
            $task->save();
            // return "OK";

            return response()->json([
                "message" => "success",
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $task = Todo::find($id);
            $task->status = '1';
            $task->save();
            return "OK";
        }
    }
}
