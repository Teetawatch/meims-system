<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;

class Dashboard extends Component
{
    public function render()
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

        return view('components.student.dashboard', [
            'student' => $student,
            'recentDocuments' => $recentDocuments
        ])->layout('components.layouts.student', ['title' => 'Dashboard - ' . $student->first_name_th]);
    }
}
