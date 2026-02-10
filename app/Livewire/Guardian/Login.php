<?php

namespace App\Livewire\Guardian;

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

        if (Auth::guard('guardian')->attempt(['username' => $this->username, 'password' => $this->password, 'is_active' => true], $this->remember)) {
            $guardian = Auth::guard('guardian')->user();
            $guardian->update(['last_login_at' => now()]);
            session()->regenerate();
            return redirect()->intended(route('guardian.dashboard'));
        }

        $this->addError('username', 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');
    }

    public function render()
    {
        return view('components.guardian.login')->layout('components.layouts.guardian', ['title' => 'เข้าสู่ระบบผู้ปกครอง']);
    }
}
