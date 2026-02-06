<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Conduct extends Component
{
    public function render()
    {
        $student = Auth::guard('student')->user();
        $scores = $student->conductScores()->latest()->get();

        return view('components.student.conduct', [
            'student' => $student,
            'scores' => $scores
        ])->layout('components.layouts.student', ['title' => 'คะแนนความประพฤติ']);
    }
}
