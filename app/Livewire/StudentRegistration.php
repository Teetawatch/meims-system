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
        'course_name' => '', // Still keeping for display if needed
        'course_id' => '', // Add this
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
        'state.course_id' => 'required|exists:courses,id',
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

        // Populate course_name if course_id is set
        if (!empty($data['course_id'])) {
            $course = \App\Models\Course::find($data['course_id']);
            if ($course) {
                $data['course_name'] = $course->course_name_th;
            } else {
                $data['course_id'] = null; // Clean up invalid ID
            }
        }

        // Handle Password
        $data['password'] = Hash::make($data['password']); // Using generic Hash facade

        // Handle Photo Upload
        if ($this->photo) {
            $data['photo_path'] = $this->photo->store('photos', 'public');
        }

        // Remove array fields that cause conversion errors
        unset($data['siblings_info']);

        // Sanitize numeric fields: Strict check, convert non-numeric (like '-') to null
        $numericFields = [
            'father_age',
            'father_income',
            'mother_age',
            'mother_income',
            'total_family_income',
            'family_members_count',
            'gpa_y1_t1',
            'gpa_y1_t2',
            'weight',
            'height'
        ];

        foreach ($numericFields as $field) {
            if (array_key_exists($field, $data)) {
                if ($data[$field] === '' || !is_numeric($data[$field])) {
                    $data[$field] = null;
                }
            }
        }

        // Sanitize DATE fields: Convert empty strings to null
        $dateFields = [
            'birth_date',
            'enrollment_date'
        ];

        foreach ($dateFields as $field) {
            if (array_key_exists($field, $data)) {
                if (empty($data[$field])) {
                    $data[$field] = null;
                }
            }
        }

        // Auto-calculate total family income if valid numbers exist
        if (empty($data['total_family_income'])) {
            $father = (isset($data['father_income']) && is_numeric($data['father_income'])) ? (float) $data['father_income'] : 0;
            $mother = (isset($data['mother_income']) && is_numeric($data['mother_income'])) ? (float) $data['mother_income'] : 0;

            if ($father > 0 || $mother > 0) {
                $data['total_family_income'] = $father + $mother;
            }
        }

        Student::create($data);

        // Dispatch event to show SweetAlert on frontend
        $this->dispatch('registration-success');
    }

    public function render()
    {
        $courses = \App\Models\Course::where('is_active', true)->get();
        return view('components.student-registration', [
            'courses' => $courses
        ])->layout('components.layouts.app');
    }
}
