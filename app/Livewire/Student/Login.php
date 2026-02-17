<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $username;
    public $password;
    public $remember = false;

    public function login()
    {
        $this->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('student')->attempt(['username' => $this->username, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended(route('student.dashboard'));
        }

        // Fallback: Check Leave System DB
        // User might use their Email (from Leave System) as username
        try {
            $leaveUser = \Illuminate\Support\Facades\DB::connection('leave_db')
                ->table('users')
                ->where('email', $this->username)
                ->first();

            if ($leaveUser && \Illuminate\Support\Facades\Hash::check($this->password, $leaveUser->password)) {
                // Password Correct in Leave DB!
                // Find linked Student in MEIMS
                $student = \App\Models\Student::where('leave_user_id', $leaveUser->id)
                    ->orWhere('email', $this->username) // Fallback check by email
                    ->first();

                if ($student) {
                    Auth::guard('student')->login($student, $this->remember);
                    session()->regenerate();
                    return redirect()->intended(route('student.dashboard'));
                }
            }
        } catch (\Exception $e) {
            // Ignore DB connection errors, fall through to error message
        }

        $this->addError('username', 'รหัสประจำตัวหรือรหัสผ่านไม่ถูกต้อง');
    }

    public function render()
    {
        return view('components.student.login')->layout('components.layouts.student', ['title' => 'เข้าสู่ระบบนักเรียน']);
    }
}
