<?php

namespace App\Livewire\Guardian;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Grade;

class StudentInfo extends Component
{
    public Student $student;

    public function mount(Student $student)
    {
        $guardian = Auth::guard('guardian')->user();

        // Verify guardian has access to this student
        if (!$guardian->students->contains($student->id)) {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงข้อมูลนักเรียนนี้');
        }
    }

    public function render()
    {
        $guardian = Auth::guard('guardian')->user();
        $grades = Grade::where('student_id', $this->student->id)
            ->with('subject')
            ->latest()
            ->get();

        $conductScores = $this->student->conductScores()->latest()->take(10)->get();

        return view('components.guardian.student-info', [
            'guardian' => $guardian,
            'student' => $this->student,
            'grades' => $grades,
            'conductScores' => $conductScores,
        ])->layout('components.layouts.guardian', ['title' => 'ข้อมูล ' . $this->student->first_name_th]);
    }
}
