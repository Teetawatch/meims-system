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

    public function updatingSearch()
    {
        $this->resetPage();
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
        $students = Student::query()
            ->when($this->search, function ($query) {
                $query->where('first_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('student_id', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('components.student-management', [
            'students' => $students
        ])->layout('components.layouts.app');
    }

    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('message', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
