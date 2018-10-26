<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\User;
use Auth;

class UserController extends Controller
{
    public function show()
    {
        return view('profile.update');
    }
    public function edit()
    {
        $id = Auth::user()->id;
        $currentuser = User::find($id);

        return response()->json($currentuser);
    }

    public function update(StoreUser $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
        return response()->json(["message" => "success"]);
    }
}
