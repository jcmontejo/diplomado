<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SuplantacionController extends Controller
{
    public function suplantar(User $user)
    {
        $originalUser = auth()->id();

        if ($user->id !== $originalUser) {
            session()->put('original-user', $originalUser);

            auth()->login($user);
        }

        return back();
    }

    public function revertir()
    {
        $originalUser = session()->get('original-user');
        auth()->loginUsingId($originalUser);
        session()->forget('original-user');

        return back();
    }
}
