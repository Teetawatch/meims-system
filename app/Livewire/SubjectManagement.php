<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Teacher;
use App\Imports\SubjectsImport;
use App\Exports\SubjectTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class SubjectManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $searchCourse = '';
    public $teacherSearch = '';

    public $isModalOpen = false;
    public $isEditMode = false;
    public $isImportModalOpen = false;

    // ... fields

    public function downloadTemplate()
    {
        return Excel::download(new SubjectTemplateExport, 'subject_template.xlsx');
    }

    // Form fields
    public $subjectId;
    public $subject_code;
    public $subject_name_th;
    public $subject_name_en;
    public $credits;
    public $course_id;
    public $description;
    public $is_active = true;
    public $selectedTeachers = [];

    // Import fields
    public $importFile;

    protected $listeners = ['deleteSubject' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSearchCourse()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['subjectId', 'subject_code', 'subject_name_th', 'subject_name_en', 'credits', 'course_id', 'description', 'is_active', 'selectedTeachers']);
        $this->isEditMode = false;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function openImportModal()
    {
        $this->resetValidation();
        $this->reset(['importFile']);
        $this->isImportModalOpen = true;
    }

    public function closeImportModal()
    {
        $this->isImportModalOpen = false;
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $this->subjectId = $id;
        $this->subject_code = $subject->subject_code;
        $this->subject_name_th = $subject->subject_name_th;
        $this->subject_name_en = $subject->subject_name_en;
        $this->credits = $subject->credits;
        $this->course_id = $subject->course_id;
        $this->description = $subject->description;
        $this->is_active = $subject->is_active;
        $this->selectedTeachers = $subject->teacher->pluck('id')->toArray();

        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $rules = [
            'subject_name_th' => 'required|string|max:255',
            'subject_name_en' => 'nullable|string|max:255',
            'credits' => 'required|integer|min:0',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'selectedTeachers' => 'nullable|array',
        ];

        if ($this->isEditMode) {
            $rules['subject_code'] = 'required|string|max:50|unique:subjects,subject_code,' . $this->subjectId;
        } else {
            $rules['subject_code'] = 'required|string|max:50|unique:subjects,subject_code';
        }

        $this->validate($rules);

        if ($this->isEditMode) {
            $subject = Subject::findOrFail($this->subjectId);
            $subject->update([
                'subject_code' => $this->subject_code,
                'subject_name_th' => $this->subject_name_th,
                'subject_name_en' => $this->subject_name_en,
                'credits' => $this->credits,
                'course_id' => $this->course_id,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            $subject->teacher()->sync($this->selectedTeachers);
            $message = 'อัปเดตข้อมูลรายวิชาเรียบร้อยแล้ว';
        } else {
            $subject = Subject::create([
                'subject_code' => $this->subject_code,
                'subject_name_th' => $this->subject_name_th,
                'subject_name_en' => $this->subject_name_en,
                'credits' => $this->credits,
                'course_id' => $this->course_id,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            $subject->teacher()->sync($this->selectedTeachers);
            $message = 'เพิ่มรายวิชาใหม่เรียบร้อยแล้ว';
        }

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => $message
        ]);

        $this->closeModal();
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new SubjectsImport, $this->importFile->getRealPath());

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'สำเร็จ!',
                'text' => 'นำเข้าข้อมูลรายวิชาเรียบร้อยแล้ว'
            ]);

            $this->closeImportModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'เกิดข้อผิดพลาด!',
                'text' => 'ไม่สามารถนำเข้าข้อมูลได้ ตรวจสอบรูปแบบไฟล์ให้ถูกต้อง (' . $e->getMessage() . ')'
            ]);
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'คุณแน่ใจหรือไม่?',
            'text' => 'หากลบแล้วจะไม่สามารถกู้คืนข้อมูลได้!',
            'method' => 'deleteSubject',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Subject::find($id)->delete();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ลบสำเร็จ!',
            'text' => 'ข้อมูลรายวิชาถูกลบเรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        $subjects = Subject::query()
            ->with('course')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('subject_code', 'like', '%' . $this->search . '%')
                        ->orWhere('subject_name_th', 'like', '%' . $this->search . '%')
                        ->orWhere('subject_name_en', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->searchCourse, function ($query) {
                $query->where('course_id', $this->searchCourse);
            })
            ->orderBy('subject_code', 'asc')
            ->paginate(10);

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();
        $teachers = Teacher::where('is_active', true)
            ->when($this->teacherSearch, function ($query) {
                $query->where('first_name_th', 'like', '%' . $this->teacherSearch . '%')
                      ->orWhere('last_name_th', 'like', '%' . $this->teacherSearch . '%');
            })
            ->orderBy('first_name_th')->get();

        return view('components.subject-management', [
            'subjects' => $subjects,
            'courses' => $courses,
            'teachers' => $teachers,
        ])->layout('components.layouts.app');
    }
}
