<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\SurveyTopic;
use Illuminate\Support\Facades\Auth;

class Surveys extends Component
{
    public function render()
    {
        $surveys = SurveyTopic::where('is_active', true)->latest()->get();

        return view('components.student.surveys', [
            'surveys' => $surveys
        ])->layout('components.layouts.student', ['title' => 'แบบสอบถาม']);
    }
}
