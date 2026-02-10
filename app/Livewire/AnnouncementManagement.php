<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Announcement;
use App\Models\Student;
use App\Models\Guardian;
use App\Notifications\NewAnnouncement;
use Illuminate\Support\Facades\Notification;

class AnnouncementManagement extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;

    // Form Fields
    public $announcementId;
    public $title, $content, $type = 'general';
    public $attachment;
    public $existingAttachment;
    public $target_audiences = []; // ['students', 'guardians']
    public $is_published = true;

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        $announcements = Announcement::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('components.announcement-management', [
            'announcements' => $announcements
        ])->layout('components.layouts.admin');
    }

    public function create()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->is_published = true;
        $this->target_audiences = ['students']; // Default
        $this->showModal = true;
    }

    public function edit(Announcement $announcement)
    {
        $this->resetFields();
        $this->isEdit = true;
        $this->announcementId = $announcement->id;
        $this->title = $announcement->title;
        $this->content = $announcement->content;
        $this->type = $announcement->type;
        $this->is_published = $announcement->is_published;
        $this->existingAttachment = $announcement->attachment_path;
        
        // Decode JSON target audiences
        $this->target_audiences = is_array($announcement->target_audiences) 
            ? $announcement->target_audiences 
            : json_decode($announcement->target_audiences, true) ?? [];

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'type' => 'required',
            'target_audiences' => 'required|array|min:1',
            'attachment' => 'nullable|file|max:10240', // 10MB
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'target_audiences' => $this->target_audiences,
            'is_published' => $this->is_published,
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('announcements', 'public');
            $data['attachment_path'] = $path;
        }

        if ($this->isEdit) {
            $announcement = Announcement::find($this->announcementId);
            $announcement->update($data);
            $message = 'แก้ไขประกาศเรียบร้อยแล้ว';
        } else {
            $announcement = Announcement::create($data);
            $message = 'สร้างประกาศใหม่เรียบร้อยแล้ว';

            // Send Notifications if published immediately
            if ($this->is_published) {
                $this->sendNotifications($announcement);
            }
        }

        $this->showModal = false;
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ',
            'text' => $message
        ]);
    }

    public function delete($id)
    {
        Announcement::find($id['id'])->delete();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'ยืนยันการลบ?',
            'text' => 'ประกาศนี้จะถูกลบออกจากระบบ',
            'method' => 'delete',
            'id' => $id
        ]);
    }

    private function sendNotifications($announcement)
    {
        // Notify Students
        if (in_array('students', $this->target_audiences)) {
            // Chunking for performance if many students
            Student::chunk(100, function ($students) use ($announcement) {
                Notification::send($students, new NewAnnouncement($announcement));
            });
        }

        // Notify Guardians
        if (in_array('guardians', $this->target_audiences)) {
            Guardian::chunk(100, function ($guardians) use ($announcement) {
                Notification::send($guardians, new NewAnnouncement($announcement));
            });
        }
    }

    private function resetFields()
    {
        $this->reset(['announcementId', 'title', 'content', 'type', 'attachment', 'existingAttachment', 'target_audiences', 'is_published']);
    }
}
