<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\Banner;

class Dashboard extends Component
{
    public function render()
    {
        $student = Auth::guard('student')->user();

        // Fetch active banners
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

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
            'recentDocuments' => $recentDocuments,
            'banners' => $banners
        ])->layout('components.layouts.student', ['title' => 'Dashboard - ' . $student->first_name_th]);
    }
}

