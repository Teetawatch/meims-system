<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;
use App\Models\ConductScore;

class StudentConduct extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedStudent = null;

    // Form
    public $score_type = 'deduction'; // deduction (cut), reward (add)
    public $score_amount;
    public $description;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectedStudent = null;
    }

    public function selectStudent($id)
    {
        $this->selectedStudent = Student::with([
            'conductScores' => function ($q) {
                $q->latest();
            }
        ])->find($id);

        $this->reset(['score_amount', 'description', 'score_type']);
    }

    public function saveScore()
    {
        $this->validate([
            'score_amount' => 'required|integer|min:1',
            'description' => 'required|string',
            'score_type' => 'required|in:deduction,reward',
        ]);

        $finalScore = $this->score_type === 'deduction' ? -abs($this->score_amount) : abs($this->score_amount);

        ConductScore::create([
            'student_id' => $this->selectedStudent->id,
            'score' => $finalScore,
            'type' => $this->score_type,
            'description' => $this->description,
            'recorded_by' => auth()->user()->name ?? 'Admin', // Assuming auth
        ]);

        $this->selectStudent($this->selectedStudent->id); // Refresh data

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'บันทึกสำเร็จ!',
            'text' => 'บันทึกคะแนนความประพฤติเรียบร้อยแล้ว'
        ]);

        $this->reset(['score_amount', 'description']);
    }

    public function deleteScore($id)
    {
        ConductScore::find($id)->delete();
        $this->selectStudent($this->selectedStudent->id);

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ลบสำเร็จ!',
            'text' => 'ลบรายการคะแนนเรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        $students = collect();
        if (strlen($this->search) > 1) {
            $students = Student::query()
                ->where('student_id', 'like', '%' . $this->search . '%')
                ->orWhere('first_name_th', 'like', '%' . $this->search . '%')
                ->orWhere('last_name_th', 'like', '%' . $this->search . '%')
                ->take(5)
                ->get();
        }

        return view('components.student-conduct', [
            'searchResults' => $students
        ])->layout('components.layouts.app');
    }
}
