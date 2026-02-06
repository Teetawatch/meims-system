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

        // Fetch timetables for the student's course
        $timetables = TimetableModel::where('course_id', $student->course_id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('components.student.timetable', [
            'timetables' => $timetables
        ])->layout('components.layouts.student', ['title' => 'ตารางเรียน']);
    }
}
