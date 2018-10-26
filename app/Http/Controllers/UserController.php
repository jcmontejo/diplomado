<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

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
        $user->name = $request->name;
        $user->email = $request->email;
        // check for password change
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();
        return response()->json(["message" => "success"]);
    }
}
