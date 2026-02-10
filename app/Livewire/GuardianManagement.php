<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuardianManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;
    
    // Guardian Form Fields
    public $guardianId;
    public $username, $password;
    public $title_th, $first_name_th, $last_name_th;
    public $phone, $email, $relationship;
    public $is_active = true;

    // Student Linking
    public $selectedStudents = []; // IDs of currently linked students
    public $studentSearch = ''; // Search term for finding students to link
    public $searchResults = []; // Results from student search

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        $guardians = Guardian::query()
            ->when($this->search, function ($query) {
                $query->where('first_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name_th', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%');
            })
            ->with('students') // Load linked students
            ->latest()
            ->paginate(10);

        return view('components.guardian-management', [
            'guardians' => $guardians
        ])->layout('components.layouts.admin');
    }

    // --- Search Students Logic ---

    public function updatedStudentSearch()
    {
        if (strlen($this->studentSearch) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = Student::where('first_name_th', 'like', '%' . $this->studentSearch . '%')
            ->orWhere('last_name_th', 'like', '%' . $this->studentSearch . '%')
            ->orWhere('student_id', 'like', '%' . $this->studentSearch . '%')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function addStudent($id)
    {
        if (!in_array($id, $this->selectedStudents)) {
            $this->selectedStudents[] = $id;
        }
        $this->studentSearch = '';
        $this->searchResults = [];
    }

    public function removeStudent($id)
    {
        $this->selectedStudents = array_diff($this->selectedStudents, [$id]);
    }

    public function getSelectedStudentsListProperty()
    {
        return Student::whereIn('id', $this->selectedStudents)->get();
    }

    // --- CRUD Logic ---

    public function create()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit(Guardian $guardian)
    {
        $this->resetFields();
        $this->isEdit = true;
        $this->guardianId = $guardian->id;
        
        $this->username = $guardian->username;
        $this->title_th = $guardian->title_th;
        $this->first_name_th = $guardian->first_name_th;
        $this->last_name_th = $guardian->last_name_th;
        $this->phone = $guardian->phone;
        $this->email = $guardian->email;
        $this->relationship = $guardian->relationship;
        $this->is_active = $guardian->is_active;

        // Load linked students IDs
        $this->selectedStudents = $guardian->students->pluck('id')->toArray();

        $this->showModal = true;
    }

    public function save()
    {
        $rules = [
            'username' => ['required', Rule::unique('guardians')->ignore($this->guardianId)],
            'first_name_th' => 'required',
            'last_name_th' => 'required',
            'password' => $this->isEdit ? 'nullable|min:6' : 'required|min:6',
        ];

        $this->validate($rules);

        $data = [
            'username' => $this->username,
            'title_th' => $this->title_th,
            'first_name_th' => $this->first_name_th,
            'last_name_th' => $this->last_name_th,
            'phone' => $this->phone,
            'email' => $this->email,
            'relationship' => $this->relationship,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEdit) {
            $guardian = Guardian::find($this->guardianId);
            $guardian->update($data);
        } else {
            $guardian = Guardian::create($data);
        }

        // Sync Students
        $guardian->students()->sync($this->selectedStudents);

        $this->showModal = false;
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'บันทึกสำเร็จ',
            'text' => 'ข้อมูลผู้ปกครองและบุตรหลานถูกบันทึกเรียบร้อยแล้ว'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'ยืนยันการลบ?',
            'text' => 'ข้อมูลผู้ปกครองจะถูกลบออกจากระบบ',
            'method' => 'delete',
            'id' => $id
        ]);
    }

    public function delete($id)
    {
        Guardian::find($id['id'])->delete();
    }

    private function resetFields()
    {
        $this->reset(['guardianId', 'username', 'password', 'title_th', 'first_name_th', 'last_name_th', 'phone', 'email', 'relationship', 'is_active', 'selectedStudents', 'studentSearch', 'searchResults']);
    }
}
