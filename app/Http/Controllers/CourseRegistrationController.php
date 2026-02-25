<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CourseRegistrationController extends Controller
{
    public function index()
    {
        if (!SystemSetting::isRegistrationEnabled()) {
            return view('student.registration-closed');
        }

        $courses = Course::where('is_active', true)->get();
        return view('student.course-register', compact('courses'));
    }

    public function store(Request $request)
    {
        if (!SystemSetting::isRegistrationEnabled()) {
            return redirect()->back()->with('error', 'การลงทะเบียนปิดอยู่ในขณะนี้');
        }

        // Basic validation - for production we should be more thorough
        $request->validate([
            'username' => 'required|unique:students,username',
            'password' => 'required|min:6',
            'full_name' => 'required',
            'course_id' => 'required|exists:courses,id',
            'email' => 'required|email|unique:students,email',
            'photo' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['_token', 'photo']);
            
            // Handle Photo
            if ($request->hasFile('photo')) {
                $data['photo_path'] = $request->file('photo')->store('photos', 'public');
            }

            // Authentication data
            $data['password'] = Hash::make($request->password);
            $data['student_id'] = 'C-' . strtoupper(substr(uniqid(), -6));
            
            // Map form fields to base student table
            $data['batch'] = $request->fiscal_year_batch ?? date('Y');
            $data['fiscal_year'] = $request->academic_year ?? date('Y');
            
            // Name handling
            $names = explode(' ', $request->full_name, 2);
            $data['first_name_th'] = $names[0];
            $data['last_name_th'] = $names[1] ?? '';
            $data['title_th'] = $request->rank ?? 'น.ต.'; // Use rank as title or default
            
            // Combine Address
            $addressParts = [];
            if ($request->address_no) $addressParts[] = "เลขที่ " . $request->address_no;
            if ($request->village_no) $addressParts[] = "หมู่ " . $request->village_no;
            if ($request->soi) $addressParts[] = "ซอย " . $request->soi;
            if ($request->road) $addressParts[] = "ถนน " . $request->road;
            $data['current_address'] = implode(' ', $addressParts) ?: '-';

            // Required defaults for fields not in special form
            $data['gender'] = 'Male';
            $data['id_card_number'] = $request->username; // Use username as fallback ID card
            $data['birth_date'] = now()->subYears($request->age ?? 20)->format('Y-m-d'); // Estimate birth date from age
            
            // Handle JSON fields
            $data['children_info'] = json_encode($request->children ?? []);
            $data['military_education'] = json_encode($request->mil_edu ?? []);
            $data['past_positions'] = json_encode($request->past_pos ?? []);
            
            Student::create($data);

            DB::commit();
            return redirect()->back()->with('success', 'ลงทะเบียนหลักสูตรพิเศษเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
}
