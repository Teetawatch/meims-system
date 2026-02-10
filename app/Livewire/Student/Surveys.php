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
        
        $surveys = SurveyTopic::where('is_active', true)
            ->where(function ($query) use ($student) {
                // Show surveys that have no course restriction (available to all)
                $query->whereDoesntHave('courses')
                    // OR surveys assigned to the student's course
                    ->orWhereHas('courses', function ($q) use ($student) {
                        $q->where('courses.id', $student->course_id);
                    });
            })
            ->latest()
            ->get();

        $completedSurveyIds = \App\Models\SurveyResponse::where('student_id', $student->id)
            ->pluck('survey_topic_id')
            ->toArray();

        return view('components.student.surveys', [
            'surveys' => $surveys,
            'completedSurveyIds' => $completedSurveyIds
        ])->layout('components.layouts.student', ['title' => 'แบบสอบถาม']);
    }
}
