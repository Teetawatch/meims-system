<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $student = Auth::guard('student')->user();

        if (!Hash::check($this->current_password, $student->password)) {
            $this->addError('current_password', 'รหัสผ่านปัจจุบันไม่ถูกต้อง');
            return;
        }

        $student->update([
            'password' => Hash::make($this->new_password)
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        return view('components.student.change-password')->layout('components.layouts.student', ['title' => 'เปลี่ยนรหัสผ่าน']);
    }
}
