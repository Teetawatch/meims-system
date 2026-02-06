<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Course;

class CourseManagement extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['deleteCourse' => 'delete'];

    // Modal state
    public $isModalOpen = false;
    public $isEditMode = false;
    public $courseIdBeingEdited = null;

    // Form fields
    public $course_code;
    public $course_name_th;
    public $course_name_en;
    public $duration;
    public $description;
    public $is_active = true;

    protected $rules = [
        'course_code' => 'required|string|max:255|unique:courses,course_code',
        'course_name_th' => 'required|string|max:255',
        'course_name_en' => 'nullable|string|max:255',
        'duration' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['course_code', 'course_name_th', 'course_name_en', 'duration', 'description', 'is_active', 'courseIdBeingEdited', 'isEditMode']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $course = Course::findOrFail($id);
        $this->courseIdBeingEdited = $id;
        $this->course_code = $course->course_code;
        $this->course_name_th = $course->course_name_th;
        $this->course_name_en = $course->course_name_en;
        $this->duration = $course->duration;
        $this->description = $course->description;
        $this->is_active = $course->is_active;
        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        if ($this->isEditMode) {
            $this->validate([
                'course_code' => 'required|string|max:255|unique:courses,course_code,' . $this->courseIdBeingEdited,
                'course_name_th' => 'required|string|max:255',
            ]);

            $course = Course::findOrFail($this->courseIdBeingEdited);
            $course->update([
                'course_code' => $this->course_code,
                'course_name_th' => $this->course_name_th,
                'course_name_en' => $this->course_name_en,
                'duration' => $this->duration,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'สำเร็จ!',
                'text' => 'อัปเดตข้อมูลหลักสูตรเรียบร้อยแล้ว'
            ]);
        } else {
            $this->validate();

            Course::create([
                'course_code' => $this->course_code,
                'course_name_th' => $this->course_name_th,
                'course_name_en' => $this->course_name_en,
                'duration' => $this->duration,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'สำเร็จ!',
                'text' => 'เพิ่มหลักสูตรใหม่เรียบร้อยแล้ว'
            ]);
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'คุณแน่ใจหรือไม่?',
            'text' => 'หากลบแล้วจะไม่สามารถกู้คืนข้อมูลได้!',
            'method' => 'deleteCourse',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Course::find($id)->delete();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ลบสำเร็จ!',
            'text' => 'ข้อมูลหลักสูตรถูกลบเรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        $courses = Course::query()
            ->when($this->search, function ($query) {
                $query->where('course_code', 'like', '%' . $this->search . '%')
                    ->orWhere('course_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('course_name_en', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('components.course-management', [
            'courses' => $courses
        ])->layout('components.layouts.app');
    }
}
