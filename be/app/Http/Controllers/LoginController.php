<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login() {
        return view('login.index');
    }

    public function login_post(Request $request) {
        $organizer = Organizer::where('email', $request->email)
                ->where('password_hash', $request->password)
                ->first();
        if(!$organizer) {
            return redirect()->back()->withErrors(['password' => 'Ten dang nhap mat khau khong dung']);
        }

        session(['organizer' => $organizer]);
        return redirect()->route('event.index');
    }

    public function logout() {
        session()->forget('oranizer');
        return view('login.index');
    }

}
