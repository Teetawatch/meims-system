<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class RegistrationManagementController extends Controller
{
    public function index()
    {
        $registrationEnabled = SystemSetting::isRegistrationEnabled();
        $totalRegistered = Student::count();
        $recentStudents = Student::latest()->take(10)->get();
        
        return view('admin.registration.index', compact('registrationEnabled', 'totalRegistered', 'recentStudents'));
    }

    public function toggle(Request $request)
    {
        $enabled = $request->input('enabled') ? '1' : '0';
        SystemSetting::set('student_registration_enabled', $enabled);
        
        return redirect()->back()->with('message', $enabled === '1' ? 'เปิดการลงทะเบียนแล้ว' : 'ปิดการลงทะเบียนแล้ว');
    }
}
