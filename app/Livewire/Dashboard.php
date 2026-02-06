<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Teacher;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_subjects' => Subject::count(),
            'total_teachers' => Teacher::count(),
        ];

        $recentStudents = Student::latest()->take(5)->get();

        return view('components.dashboard', [
            'stats' => $stats,
            'recentStudents' => $recentStudents
        ])->layout('components.layouts.app');
    }
}
