<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        // Fetch recent documents for the student
        $recentDocuments = Document::where('is_active', true)
            ->where(function ($query) use ($student) {
                $query->whereNull('course_id')
                    ->orWhere('course_id', $student->course_id);
            })
            ->latest()
            ->take(4)
            ->get();

        return view('student.dashboard', [
            'student' => $student,
            'recentDocuments' => $recentDocuments
        ]);
    }
}
