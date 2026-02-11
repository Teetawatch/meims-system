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
        $courseId = $student->course_id;

        // Fallback: If course_id is null, try to find it by course_name (for imported data)
        if (!$courseId && $student->course_name) {
            $course = \App\Models\Course::where('course_name_th', $student->course_name)->first();
            if ($course) {
                $courseId = $course->id;
            }
        }

        // Fetch general documents and documents specific to the student's course
        $documents = Document::where('is_active', true)
            ->where(function ($query) use ($courseId) {
                $query->whereNull('course_id')
                    ->orWhere('course_id', $courseId);
            })
            ->orderBy('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('components.student.documents', [
            'documents' => $documents
        ])->layout('components.layouts.student', ['title' => 'ดาวน์โหลดเอกสาร']);
    }
}
