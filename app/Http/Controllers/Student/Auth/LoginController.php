<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }
        return view('student.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('student')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('student.dashboard'));
        }

        return back()->withErrors([
            'username' => 'รหัสประจำตัวหรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        return redirect()->route('student.login');
    }
}
