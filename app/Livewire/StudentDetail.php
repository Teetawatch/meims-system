<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;

class StudentDetail extends Component
{
    public Student $student;

    public function mount(Student $student)
    {
        $this->student = $student;
    }

    public function render()
    {
        return view('components.student-detail')->layout('components.layouts.app');
    }
}
