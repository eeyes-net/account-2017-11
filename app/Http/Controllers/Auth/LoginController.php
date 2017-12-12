<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Subfission\Cas\Facades\Cas;

class LoginController extends Controller
{
    public function login()
    {
        Cas::authenticate();
        $net_id = Cas::user();
        $user = User::whereUsername($net_id)->first();
        if (!$user) {
            $user = User::newByNetId($net_id);
            $user->save();
        }
        Auth::login($user);
        return redirect()->intended('/');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        Session::save();
        Cas::logout(url('/'));
        // never reach
    }
}
