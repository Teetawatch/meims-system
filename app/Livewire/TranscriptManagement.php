<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;
use App\Models\Course;

class TranscriptManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $courseFilter = '';
    public $batchFilter = '';
    public $yearFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::query()
            ->with('course')
            ->when($this->search, function ($query) {
                $query->where('first_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('student_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->courseFilter, function ($query) {
                $query->where('course_id', $this->courseFilter);
            })
            ->when($this->batchFilter, function ($query) {
                $query->where('batch', $this->batchFilter);
            })
            ->when($this->yearFilter, function ($query) {
                $query->where('fiscal_year', $this->yearFilter);
            })
            ->paginate(15);

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();
        $batches = Student::distinct()->pluck('batch');
        $years = Student::distinct()->pluck('fiscal_year');

        return view('components.transcript-management', [
            'students' => $students,
            'courses' => $courses,
            'batches' => $batches,
            'years' => $years,
        ])->layout('components.layouts.app');
    }
}
