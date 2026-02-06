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

        $this->addError('username', 'รหัสประจำตัวหรือรหัสผ่านไม่ถูกต้อง');
    }

    public function render()
    {
        return view('components.student.login')->layout('components.layouts.student', ['title' => 'เข้าสู่ระบบนักเรียน']);
    }
}
