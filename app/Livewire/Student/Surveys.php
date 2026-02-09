<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\SurveyTopic;
use Illuminate\Support\Facades\Auth;

class Surveys extends Component
{
    public function render()
    {
        $student = Auth::guard('student')->user();
        $surveys = SurveyTopic::where('is_active', true)->latest()->get();
        $completedSurveyIds = \App\Models\SurveyResponse::where('student_id', $student->id)
            ->pluck('survey_topic_id')
            ->toArray();

        return view('components.student.surveys', [
            'surveys' => $surveys,
            'completedSurveyIds' => $completedSurveyIds
        ])->layout('components.layouts.student', ['title' => 'แบบสอบถาม']);
    }
}
