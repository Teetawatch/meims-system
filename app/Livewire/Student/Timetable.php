<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Timetable as TimetableModel;
use Illuminate\Support\Facades\Auth;

class Timetable extends Component
{
    public function render()
    {
        $student = Auth::guard('student')->user();
        $courseId = $student->course_id;

        // If no direct relationship, try to find course by name string
        if (!$courseId && $student->course_name) {
            $course = \App\Models\Course::where('course_name_th', 'like', '%' . $student->course_name . '%')
                ->orWhere('course_name_en', 'like', '%' . $student->course_name . '%')
                ->orWhere('course_code', $student->course_name)
                ->first();

            if ($course) {
                $courseId = $course->id;
            }
        }

        // Fetch timetables for the student's course
        $timetables = collect();

        if ($courseId) {
            $timetables = TimetableModel::where('course_id', $courseId)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('components.student.timetable', [
            'timetables' => $timetables
        ])->layout('components.layouts.student', ['title' => 'ตารางเรียน']);
    }
}
