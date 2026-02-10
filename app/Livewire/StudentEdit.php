<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class StudentEdit extends Component
{
    use WithFileUploads;

    public Student $student;
    public $currentStep = 1;
    public $totalSteps = 6;

    // Form State
    public $state = [
        // Account
        'username' => '',
        'password' => '',
        'photo_path' => null,

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

        // Education
        'enrollment_date' => '',
        'degree_level' => '',
        'course_name' => '',
        'course_id' => '',
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

    public $photo; // For new file upload

    public function mount(Student $student)
    {
        $this->student = $student;

        // Populate state from existing student data
        foreach ($this->state as $key => $value) {
            if ($key === 'password') {
                // Don't populate password - leave blank for optional change
                $this->state[$key] = '';
                continue;
            }

            $studentValue = $student->{$key};

            // Format date fields for HTML date inputs
            if (in_array($key, ['birth_date', 'enrollment_date']) && $studentValue) {
                $this->state[$key] = $studentValue instanceof \Carbon\Carbon
                    ? $studentValue->format('Y-m-d')
                    : $studentValue;
            } else {
                $this->state[$key] = $studentValue ?? '';
            }
        }
    }

    protected function rules()
    {
        return [
            'state.username' => 'required|unique:students,username,' . $this->student->id,
            'state.student_id' => 'required|unique:students,student_id,' . $this->student->id,
            'state.first_name_th' => 'required',
            'state.last_name_th' => 'required',
            'state.email' => 'required|email|unique:students,email,' . $this->student->id,
        ];
    }

    public function nextStep()
    {
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function update()
    {
        $this->validate();

        $data = $this->state;

        // Populate course_name if course_id is set
        if (!empty($data['course_id'])) {
            $course = \App\Models\Course::find($data['course_id']);
            if ($course) {
                $data['course_name'] = $course->course_name_th;
            } else {
                $data['course_id'] = null;
            }
        }

        // Handle Password - only update if a new password was entered
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Don't overwrite existing password
        }

        // Handle Photo Upload
        if ($this->photo) {
            // Delete old photo if exists
            if ($this->student->photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->student->photo_path);
            }
            $data['photo_path'] = $this->photo->store('photos', 'public');
        } else {
            // Keep existing photo
            unset($data['photo_path']);
        }

        // Sanitize numeric fields
        $numericFields = [
            'father_age', 'father_income', 'mother_age', 'mother_income',
            'total_family_income', 'family_members_count',
            'gpa_y1_t1', 'gpa_y1_t2', 'weight', 'height'
        ];

        foreach ($numericFields as $field) {
            if (array_key_exists($field, $data)) {
                if ($data[$field] === '' || !is_numeric($data[$field])) {
                    $data[$field] = null;
                }
            }
        }

        // Sanitize DATE fields
        $dateFields = ['birth_date', 'enrollment_date'];
        foreach ($dateFields as $field) {
            if (array_key_exists($field, $data)) {
                if (empty($data[$field])) {
                    $data[$field] = null;
                }
            }
        }

        // Auto-calculate total family income if not set
        if (empty($data['total_family_income'])) {
            $father = (isset($data['father_income']) && is_numeric($data['father_income'])) ? (float) $data['father_income'] : 0;
            $mother = (isset($data['mother_income']) && is_numeric($data['mother_income'])) ? (float) $data['mother_income'] : 0;
            if ($father > 0 || $mother > 0) {
                $data['total_family_income'] = $father + $mother;
            }
        }

        // Convert empty strings to null for non-required fields
        foreach ($data as $key => $value) {
            if ($value === '' && !in_array($key, ['username', 'student_id', 'first_name_th', 'last_name_th', 'email'])) {
                $data[$key] = null;
            }
        }

        $this->student->update($data);

        $this->dispatch('update-success');
    }

    public function render()
    {
        $courses = \App\Models\Course::where('is_active', true)->get();
        return view('components.student-edit', [
            'courses' => $courses
        ])->layout('components.layouts.app');
    }
}
