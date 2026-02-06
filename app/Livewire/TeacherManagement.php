<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Teacher;

class TeacherManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $isModalOpen = false;
    public $teacherId, $teacher_code, $title_th, $first_name_th, $last_name_th, $title_en, $first_name_en, $last_name_en, $position, $email, $phone, $is_active = true;

    protected $listeners = ['deleteTeacher' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function resetFields()
    {
        $this->teacherId = null;
        $this->teacher_code = '';
        $this->title_th = '';
        $this->first_name_th = '';
        $this->last_name_th = '';
        $this->title_en = '';
        $this->first_name_en = '';
        $this->last_name_en = '';
        $this->position = '';
        $this->email = '';
        $this->phone = '';
        $this->is_active = true;
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        $this->teacherId = $id;
        $this->teacher_code = $teacher->teacher_code;
        $this->title_th = $teacher->title_th;
        $this->first_name_th = $teacher->first_name_th;
        $this->last_name_th = $teacher->last_name_th;
        $this->title_en = $teacher->title_en;
        $this->first_name_en = $teacher->first_name_en;
        $this->last_name_en = $teacher->last_name_en;
        $this->position = $teacher->position;
        $this->email = $teacher->email;
        $this->phone = $teacher->phone;
        $this->is_active = $teacher->is_active;

        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'teacher_code' => 'required|unique:teachers,teacher_code,' . $this->teacherId,
            'first_name_th' => 'required|string',
            'last_name_th' => 'required|string',
            'email' => 'nullable|email',
        ]);

        $data = [
            'teacher_code' => $this->teacher_code,
            'title_th' => $this->title_th,
            'first_name_th' => $this->first_name_th,
            'last_name_th' => $this->last_name_th,
            'title_en' => $this->title_en,
            'first_name_en' => $this->first_name_en,
            'last_name_en' => $this->last_name_en,
            'position' => $this->position,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
        ];

        if ($this->teacherId) {
            Teacher::find($this->teacherId)->update($data);
        } else {
            Teacher::create($data);
        }

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => 'บันทึกข้อมูลอาจารย์เรียบร้อยแล้ว'
        ]);

        $this->isModalOpen = false;
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'คุณแน่ใจหรือไม่?',
            'text' => 'ข้อมูลอาจารย์จะถูกลบออกจากระบบ!',
            'method' => 'deleteTeacher',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Teacher::destroy($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ลบสำเร็จ!',
            'text' => 'ลบข้อมูลอาจารย์เรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        $teachers = Teacher::query()
            ->when($this->search, function ($query) {
                $query->where('first_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('teacher_code', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        return view('components.teacher-management', [
            'teachers' => $teachers
        ])->layout('components.layouts.app');
    }
}
