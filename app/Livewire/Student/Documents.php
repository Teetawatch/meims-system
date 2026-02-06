<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class Documents extends Component
{
    public function render()
    {
        $student = Auth::guard('student')->user();

        // Fetch general documents and documents specific to the student's course
        $documents = Document::where('is_active', true)
            ->where(function ($query) use ($student) {
                $query->whereNull('course_id')
                    ->orWhere('course_id', $student->course_id);
            })
            ->orderBy('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('components.student.documents', [
            'documents' => $documents
        ])->layout('components.layouts.student', ['title' => 'ดาวน์โหลดเอกสาร']);
    }
}
