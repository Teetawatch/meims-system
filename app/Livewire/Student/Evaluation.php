<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Subject;
use App\Models\TeacherEvaluation;
use App\Models\PeerEvaluation;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class Evaluation extends Component
{
    public function render()
    {
        $student = Auth::guard('student')->user();

        // Find subjects in student's course
        $subjects = Subject::where('course_id', $student->course_id)
            ->where('is_active', true)
            ->with('teacher')
            ->get();

        // Check which have been evaluated
        $evaluatedTeachers = TeacherEvaluation::where('student_id', $student->id)
            ->pluck('subject_id')
            ->toArray();

        // Peer evaluation: usually done per semester for all classmates
        $classmates = Student::where('course_id', $student->course_id)
            ->where('batch', $student->batch)
            ->where('id', '!=', $student->id) // Cannot evaluate self
            ->get();

        $evaluatedPeers = PeerEvaluation::where('student_id', $student->id)
            ->pluck('target_student_id')
            ->toArray();

        return view('components.student.evaluation', [
            'subjects' => $subjects,
            'evaluatedTeachers' => $evaluatedTeachers,
            'classmates' => $classmates,
            'evaluatedPeers' => $evaluatedPeers,
        ])->layout('components.layouts.student', ['title' => 'ระบบประเมิน']);
    }
}
