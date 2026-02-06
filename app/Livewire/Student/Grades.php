<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Grades extends Component
{
    public function render()
    {
        $student = Auth::guard('student')->user();

        return view('components.student.grades', [
            'student' => $student
        ])->layout('components.layouts.student', ['title' => 'ผลการเรียน']);
    }
}
