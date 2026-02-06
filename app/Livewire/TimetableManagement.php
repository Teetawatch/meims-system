<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Timetable;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class TimetableManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $isModalOpen = false;
    public $isEditMode = false;

    // Form fields
    public $timetableId;
    public $title;
    public $description;
    public $course_id;
    public $is_active = true;
    public $pdfFile;
    public $existingFilePath;

    protected $listeners = ['deleteTimetable' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['timetableId', 'title', 'description', 'course_id', 'is_active', 'pdfFile', 'existingFilePath']);
        $this->is_active = true;
        $this->isEditMode = false;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function edit($id)
    {
        $timetable = Timetable::findOrFail($id);
        $this->timetableId = $id;
        $this->title = $timetable->title;
        $this->description = $timetable->description;
        $this->course_id = $timetable->course_id;
        $this->is_active = $timetable->is_active;
        $this->existingFilePath = $timetable->file_path;

        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'is_active' => 'boolean',
        ];

        if (!$this->isEditMode) {
            $rules['pdfFile'] = 'required|file|mimes:pdf|max:10240'; // Max 10MB
        } else {
            $rules['pdfFile'] = 'nullable|file|mimes:pdf|max:10240';
        }

        $this->validate($rules);

        $filePath = $this->existingFilePath;
        if ($this->pdfFile) {
            // Delete old file if editing
            if ($this->isEditMode && $this->existingFilePath) {
                Storage::disk('public')->delete($this->existingFilePath);
            }
            // Store new file
            $filePath = $this->pdfFile->store('timetables', 'public');
        }

        if ($this->isEditMode) {
            $timetable = Timetable::findOrFail($this->timetableId);
            $timetable->update([
                'title' => $this->title,
                'description' => $this->description,
                'course_id' => $this->course_id,
                'is_active' => $this->is_active,
                'file_path' => $filePath,
            ]);
            $message = 'อัปเดตตารางเรียนเรียบร้อยแล้ว';
        } else {
            Timetable::create([
                'title' => $this->title,
                'description' => $this->description,
                'course_id' => $this->course_id,
                'is_active' => $this->is_active,
                'file_path' => $filePath,
            ]);
            $message = 'เพิ่มตารางเรียนเรียบร้อยแล้ว';
        }

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => $message
        ]);

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'คุณแน่ใจหรือไม่?',
            'text' => 'ไฟล์ตารางเรียนจะถูกลบออกจากระบบ!',
            'method' => 'deleteTimetable',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        $timetable = Timetable::findOrFail($id);
        if ($timetable->file_path) {
            Storage::disk('public')->delete($timetable->file_path);
        }
        $timetable->delete();

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ลบสำเร็จ!',
            'text' => 'ลบตารางเรียนเรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        $timetables = Timetable::query()
            ->with('course')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('course', function ($q) {
                        $q->where('course_name_th', 'like', '%' . $this->search . '%')
                            ->orWhere('course_code', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();

        return view('components.timetable-management', [
            'timetables' => $timetables,
            'courses' => $courses,
        ])->layout('components.layouts.app');
    }
}
