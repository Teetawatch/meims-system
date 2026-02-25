<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StudentRegistrationController extends Controller
{
    public function index()
    {
        if (!\App\Models\SystemSetting::isRegistrationEnabled()) {
            return view('student.registration-closed');
        }

        $courses = Course::where('is_active', true)->get();
        return view('student.register', compact('courses'));
    }

    public function store(Request $request)
    {
        if (!\App\Models\SystemSetting::isRegistrationEnabled()) {
            return redirect()->route('student.register')->with('error', 'การลงทะเบียนปิดอยู่ในขณะนี้');
        }
        $validatedData = $request->validate([
            'username' => 'required|unique:students,username',
            'password' => 'required|min:6',
            'student_id' => 'required|unique:students,student_id',
            'first_name_th' => 'required',
            'last_name_th' => 'required',
            'course_id' => 'required|exists:courses,id',
            'email' => 'required|email|unique:students,email',
            'photo' => 'nullable|image|max:2048',
            // Allow other fields
        ]);
        
        $data = $request->except(['_token', 'photo']);

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('', 'images');
            $data['photo_path'] = 'images/' . $path;
        }

        // Handle Password
        $data['password'] = Hash::make($data['password']);

        // Populate course_name if course_id is set
        if (!empty($data['course_id'])) {
            $course = Course::find($data['course_id']);
            if ($course) {
                $data['course_name'] = $course->course_name_th;
            } else {
                $data['course_id'] = null;
            }
        }

        // Sanitize numeric fields: Strict check, convert non-numeric to null
        $numericFields = [
            'father_age', 'father_income', 'mother_age', 'mother_income',
            'total_family_income', 'family_members_count', 'gpa_y1_t1',
            'gpa_y1_t2', 'weight', 'height'
        ];

        foreach ($numericFields as $field) {
            if (array_key_exists($field, $data)) {
                if ($data[$field] === '' || !is_numeric($data[$field])) {
                    $data[$field] = null;
                }
            }
        }

        // Sanitize DATE fields: Convert empty strings to null
        $dateFields = ['birth_date', 'enrollment_date'];
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

        return redirect()->route('student.login')->with('success', 'ลงทะเบียนนักเรียนใหม่เรียบร้อยแล้ว กรุณาเข้าสู่ระบบ');
    }
}
