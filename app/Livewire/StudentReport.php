<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;
use App\Exports\StudentReportExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentReport extends Component
{
    use WithPagination;

    public $fiscal_year;
    public $batch;
    public $course_name;

    // Filter Options
    public $fiscal_years = [];
    public $batches = [];
    public $courses = [];

    public function mount()
    {
        // Load available filter options from DB
        $this->fiscal_years = Student::select('fiscal_year')->distinct()->orderBy('fiscal_year', 'desc')->pluck('fiscal_year');
        $this->batches = Student::select('batch')->distinct()->orderBy('batch', 'desc')->pluck('batch');
        $this->courses = Student::select('course_name')->distinct()->orderBy('course_name')->pluck('course_name');
    }

    public function updated($propertyName)
    {
        $this->resetPage(); // Reset pagination when filters change
    }

    public function resetFilters()
    {
        $this->reset(['fiscal_year', 'batch', 'course_name']);
        $this->resetPage();
    }

    public function export()
    {
        $filters = [
            'fiscal_year' => $this->fiscal_year,
            'batch' => $this->batch,
            'course_name' => $this->course_name,
        ];

        return Excel::download(new StudentReportExport($filters), 'student_report_' . date('Y-m-d') . '.xlsx');
    }

    private function getFilteredQuery()
    {
        $query = Student::query();

        if ($this->fiscal_year) {
            $query->where('fiscal_year', $this->fiscal_year);
        }

        if ($this->batch) {
            $query->where('batch', $this->batch);
        }

        if ($this->course_name) {
            $query->where('course_name', $this->course_name);
        }

        return $query;
    }

    public function render()
    {
        $students = $this->getFilteredQuery()->paginate(10);

        return view('components.student-report', [
            'students' => $students
        ])->layout('components.layouts.app');
    }
}
