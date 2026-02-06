<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class StudentRegistration extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 6;

    // Form State
    public $state = [
        // Account
        'username' => '',
        'password' => '',
        'photo_path' => null, // Handle separately for upload

        // General
        'student_id' => '',
        'batch' => '',
        'fiscal_year' => '',
        'id_card_number' => '',
        'gender' => '',
        'title_th' => '',
        'first_name_th' => '',
        'last_name_th' => '',
        'title_en' => '',
        'first_name_en' => '',
        'last_name_en' => '',

        // Personal
        'birth_date' => '',
        'blood_type' => '',
        'religion' => '',
        'race' => '',
        'nationality' => '',
        'birth_province' => '',

        // Contact
        'phone' => '',
        'email' => '',

        // Address
        'current_address' => '',
        'subdistrict' => '',
        'district' => '',
        'province' => '',
        'zip_code' => '',
        'housing_status' => '',
        'residence_type' => '',

        // Family
        'father_name' => '',
        'father_age' => '',
        'father_occupation' => '',
        'father_income' => '',
        'mother_name' => '',
        'mother_age' => '',
        'mother_occupation' => '',
        'mother_income' => '',
        'parents_marital_status' => '',
        'total_family_income' => '',
        'family_members_count' => '',
        'siblings_info' => [], // Will need UI to add siblings

        // Education
        'enrollment_date' => '',
        'degree_level' => '',
        'course_name' => '',
        'gpa_y1_t1' => '',
        'gpa_y1_t2' => '',

        // Health
        'weight' => '',
        'height' => '',
        'disabilities' => '',
        'chronic_diseases' => '',
        'allergies' => '',
        'mental_health_notes' => '',
    ];

    public $photo; // For file upload

    protected $rules = [
        'state.username' => 'required|unique:students,username',
        'state.password' => 'required|min:6',
        'state.student_id' => 'required|unique:students,student_id',
        'state.first_name_th' => 'required',
        'state.last_name_th' => 'required',
        'state.email' => 'required|email|unique:students,email',
        // Add more rules as needed...
    ];

    public function mount()
    {
        // Initialize defaults if needed
    }

    public function nextStep()
    {
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function save()
    {
        $this->validate();

        $data = $this->state;

        // Handle Password
        $data['password'] = Hash::make($data['password']); // Using generic Hash facade

        // Handle Photo Upload
        if ($this->photo) {
            $data['photo_path'] = $this->photo->store('photos', 'public');
        }

        Student::create($data);

        session()->flash('message', 'Student registered successfully.');

        return redirect()->to('/'); // Redirect somewhere
    }

    public function render()
    {
        return view('components.student-registration')->layout('components.layouts.app');
    }
}
