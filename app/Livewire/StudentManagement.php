<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Student;
use App\Exports\StudentTemplateExport;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $importFile;
    public $selectedStudents = [];
    public $selectAll = false;
    public $courseFilter = '';
    public $batchFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCourseFilter()
    {
        $this->resetPage();
        $this->selectedStudents = [];
        $this->selectAll = false;
    }

    public function updatingBatchFilter()
    {
        $this->resetPage();
        $this->selectedStudents = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedStudents = $this->getFilteredQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedStudents = [];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedStudents)) {
            return;
        }

        $count = count($this->selectedStudents);
        Student::whereIn('id', $this->selectedStudents)->delete();
        $this->selectedStudents = [];
        $this->selectAll = false;

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => "ลบข้อมูลนักเรียน {$count} คนเรียบร้อยแล้ว"
        ]);
    }

    public function deleteAll()
    {
        $query = $this->getFilteredQuery();
        $count = $query->count();

        if ($count === 0) {
            return;
        }

        $query->delete();
        $this->selectedStudents = [];
        $this->selectAll = false;

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => "ลบข้อมูลนักเรียน {$count} คนเรียบร้อยแล้ว"
        ]);
    }

    private function getFilteredQuery()
    {
        return Student::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name_th', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name_th', 'like', '%' . $this->search . '%')
                        ->orWhere('student_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->courseFilter, function ($query) {
                $query->where('course_name', $this->courseFilter);
            })
            ->when($this->batchFilter, function ($query) {
                $query->where('batch', $this->batchFilter);
            });
    }

    public function downloadTemplate()
    {
        return Excel::download(new StudentTemplateExport, 'student_template.xlsx');
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new StudentsImport, $this->importFile);
            $this->reset('importFile');
            
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'สำเร็จ!',
                'text' => 'นำเข้าข้อมูลนักเรียนเรียบร้อยแล้ว'
            ]);
            
            // Close the modal via event if needed, or rely on frontend state reset
            $this->dispatch('close-import-modal');
            
        } catch (\Exception $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'เกิดข้อผิดพลาด!',
                'text' => 'ไม่สามารถนำเข้าข้อมูลได้: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $students = $this->getFilteredQuery()->paginate(10);

        $courses = Student::whereNotNull('course_name')
            ->where('course_name', '!=', '')
            ->distinct()
            ->pluck('course_name');

        $batches = Student::whereNotNull('batch')
            ->where('batch', '!=', '')
            ->distinct()
            ->orderBy('batch', 'desc')
            ->pluck('batch');

        return view('components.student-management', [
            'students' => $students,
            'courses' => $courses,
            'batches' => $batches,
        ])->layout('components.layouts.app');
    }

    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('message', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
