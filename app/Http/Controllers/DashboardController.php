<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_subjects' => Subject::count(),
            'total_teachers' => Teacher::count(),
        ];

        $recentStudents = Student::latest()->take(5)->get();

        return view('dashboard', [
            'stats' => $stats,
            'recentStudents' => $recentStudents
        ]);
    }
}
