<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Timetable as TimetableModel;

class StudentPageController extends Controller
{
    public function profile()
    {
        $student = Auth::guard('student')->user();
        return view('student.profile', compact('student'));
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $student = Auth::guard('student')->user();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('students/photos', 'public');
            $student->update([
                'photo_path' => $path
            ]);
            return redirect()->back()->with('success', 'อัปเดตรูปประจำตัวเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'ไม่สามารถอัปโหลดรูปภาพได้');
    }

    public function timetable()
    {
        $student = Auth::guard('student')->user();
        $courseId = $student->course_id;

        if (!$courseId && $student->course_name) {
            $course = \App\Models\Course::where('course_name_th', 'like', '%' . $student->course_name . '%')
                ->orWhere('course_name_en', 'like', '%' . $student->course_name . '%')
                ->orWhere('course_code', $student->course_name)
                ->first();

            if ($course) {
                $courseId = $course->id;
            }
        }

        $timetables = collect();
        if ($courseId) {
            $timetables = TimetableModel::where('course_id', $courseId)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('student.timetable', compact('timetables'));
    }

    public function grades()
    {
        $student = Auth::guard('student')->user();
        return view('student.grades', compact('student'));
    }

    public function conduct()
    {
        $student = Auth::guard('student')->user();
        $scores = $student->conductScores()->latest()->get();
        return view('student.conduct', compact('student', 'scores'));
    }

    public function documents()
    {
        $student = Auth::guard('student')->user();

        $documents = \App\Models\Document::where('is_active', true)
            ->where(function ($query) use ($student) {
                $query->whereNull('course_id')
                    ->orWhere('course_id', $student->course_id);
            })
            ->orderBy('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.documents', compact('documents'));
    }

    public function changePasswordForm()
    {
        return view('student.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $student = Auth::guard('student')->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $student->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
        }

        $student->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        return back()->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }
}
