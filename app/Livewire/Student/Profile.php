<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $student;
    public $photo;

    public function mount()
    {
        $this->student = Auth::guard('student')->user();
    }

    public function updatePhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);

        $path = $this->photo->store('students/photos', 'public');

        $this->student->update([
            'photo_path' => $path
        ]);

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => 'อัปเดตรูปประจำตัวเรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        return view('components.student.profile')->layout('components.layouts.student', ['title' => 'ข้อมูลส่วนตัว']);
    }
}
