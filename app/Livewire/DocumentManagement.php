<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Document;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $categoryFilter = '';
    public $isModalOpen = false;
    public $isEditMode = false;

    // Form fields
    public $documentId;
    public $title;
    public $description;
    public $category = 'General';
    public $course_id;
    public $is_active = true;
    public $file;
    public $existingFilePath;

    protected $listeners = ['deleteDocument' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['documentId', 'title', 'description', 'category', 'course_id', 'is_active', 'file', 'existingFilePath']);
        $this->category = 'General';
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
        $document = Document::findOrFail($id);
        $this->documentId = $id;
        $this->title = $document->title;
        $this->description = $document->description;
        $this->category = $document->category;
        $this->course_id = $document->course_id;
        $this->is_active = $document->is_active;
        $this->existingFilePath = $document->file_path;

        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
            'is_active' => 'boolean',
        ];

        if (!$this->isEditMode) {
            $rules['file'] = 'required|file|max:20480'; // Max 20MB
        } else {
            $rules['file'] = 'nullable|file|max:20480';
        }

        $this->validate($rules);

        $filePath = $this->existingFilePath;
        $fileType = null;
        $fileSize = null;

        if ($this->file) {
            // Delete old file if editing
            if ($this->isEditMode && $this->existingFilePath) {
                Storage::disk('public')->delete($this->existingFilePath);
            }

            // Store new file
            $filePath = $this->file->store('documents', 'public');
            $fileType = strtoupper($this->file->getClientOriginalExtension());
            $size = $this->file->getSize();

            if ($size >= 1048576) {
                $fileSize = number_format($size / 1048576, 2) . ' MB';
            } else {
                $fileSize = number_format($size / 1024, 2) . ' KB';
            }
        }

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'course_id' => $this->course_id,
            'is_active' => $this->is_active,
            'file_path' => $filePath,
        ];

        if ($fileType)
            $data['file_type'] = $fileType;
        if ($fileSize)
            $data['file_size'] = $fileSize;

        if ($this->isEditMode) {
            $document = Document::findOrFail($this->documentId);
            $document->update($data);
            $message = 'อัปเดตเอกสารเรียบร้อยแล้ว';
        } else {
            Document::create($data);
            $message = 'เพิ่มเอกสารเรียบร้อยแล้ว';
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
            'text' => 'ไฟล์เอกสารจะถูกลบออกจากระบบ!',
            'method' => 'deleteDocument',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ลบสำเร็จ!',
            'text' => 'ลบเอกสารเรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        $documents = Document::query()
            ->with('course')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();

        return view('components.document-management', [
            'documents' => $documents,
            'courses' => $courses,
        ])->layout('components.layouts.app');
    }
}
