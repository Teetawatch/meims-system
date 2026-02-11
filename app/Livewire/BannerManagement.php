<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerManagement extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;

    // Form Fields
    public $bannerId;
    public $title, $link_url, $sort_order = 0;
    public $image;
    public $existingImage;
    public $is_active = true;

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        $banners = Banner::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('sort_order', 'asc')
            ->paginate(10);

        return view('components.banner-management', [
            'banners' => $banners
        ])->layout('components.layouts.admin');
    }

    public function create()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->is_active = true;
        // Auto set next sort order
        $this->sort_order = Banner::max('sort_order') + 1;
        $this->showModal = true;
    }

    public function edit(Banner $banner)
    {
        $this->resetFields();
        $this->isEdit = true;
        $this->bannerId = $banner->id;
        $this->title = $banner->title;
        $this->link_url = $banner->link_url;
        $this->sort_order = $banner->sort_order;
        $this->is_active = $banner->is_active;
        $this->existingImage = $banner->image_path;
        
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'nullable|string|max:255',
            'link_url' => 'nullable|url',
            'sort_order' => 'required|integer',
            'image' => $this->isEdit ? 'nullable|image|max:5120' : 'required|image|max:5120',
        ]);

        $data = [
            'title' => $this->title,
            'link_url' => $this->link_url,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $path = $this->image->store('/', 'banners');
            $data['image_path'] = $path;
        }

        if ($this->isEdit) {
            $banner = Banner::find($this->bannerId);
            $banner->update($data);
            $message = 'แก้ไขแบนเนอร์เรียบร้อยแล้ว';
        } else {
            Banner::create($data);
            $message = 'สร้างแบนเนอร์ใหม่เรียบร้อยแล้ว';
        }

        $this->showModal = false;
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ',
            'text' => $message
        ]);
        
        $this->resetFields();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'ยืนยันการลบ?',
            'text' => 'แบนเนอร์นี้จะถูกลบออกจากระบบ',
            'method' => 'delete',
            'id' => $id
        ]);
    }

    public function delete($id)
    {
        $banner = Banner::find($id['id']);
        if ($banner->image_path) {
            Storage::disk('banners')->delete($banner->image_path);
        }
        $banner->delete();
        
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ',
            'text' => 'ลบแบนเนอร์เรียบร้อยแล้ว'
        ]);
    }

    public function toggleStatus($id)
    {
        $banner = Banner::find($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();
    }

    private function resetFields()
    {
        $this->reset(['bannerId', 'title', 'link_url', 'sort_order', 'image', 'existingImage', 'is_active']);
    }
}
