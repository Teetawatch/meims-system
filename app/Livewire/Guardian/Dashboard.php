<?php

namespace App\Livewire\Guardian;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class Dashboard extends Component
{
    public function render()
    {
        $guardian = Auth::guard('guardian')->user();
        $students = $guardian->students()->with(['course', 'conductScores'])->get();

        return view('components.guardian.dashboard', [
            'guardian' => $guardian,
            'students' => $students,
        ])->layout('components.layouts.guardian', ['title' => 'หน้าหลักผู้ปกครอง']);
    }
}
