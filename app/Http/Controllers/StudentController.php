<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Exports\StudentTemplateExport;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $courseFilter = $request->input('courseFilter');
        $batchFilter = $request->input('batchFilter');

        $students = Student::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name_th', 'like', '%' . $search . '%')
                        ->orWhere('last_name_th', 'like', '%' . $search . '%')
                        ->orWhere('student_id', 'like', '%' . $search . '%');
                });
            })
            ->when($courseFilter, function ($query) use ($courseFilter) {
                $query->where('course_name', $courseFilter);
            })
            ->when($batchFilter, function ($query) use ($batchFilter) {
                $query->where('batch', $batchFilter);
            })
            ->paginate(10);

        $courses = Student::whereNotNull('course_name')
            ->where('course_name', '!=', '')
            ->distinct()
            ->pluck('course_name');

        $batches = Student::whereNotNull('batch')
            ->where('batch', '!=', '')
            ->distinct()
            ->orderBy('batch', 'desc')
            ->pluck('batch');

        return view('students.index', compact('students', 'courses', 'batches', 'search', 'courseFilter', 'batchFilter'));
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('message', 'ลบข้อมูลเรียบร้อยแล้ว');
    }

    public function destroySelected(Request $request)
    {
        $ids = $request->input('selectedStudents', []);
        
        if (empty($ids)) {
            return redirect()->route('students.index');
        }

        $count = count($ids);
        Student::whereIn('id', $ids)->delete();

        return redirect()->route('students.index')->with('message', "ลบข้อมูลนักเรียน {$count} คนเรียบร้อยแล้ว");
    }

    public function import(Request $request)
    {
        $request->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new StudentsImport, $request->file('importFile'));
            return redirect()->route('students.index')->with('message', 'นำเข้าข้อมูลนักเรียนเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect()->route('students.index')->withErrors(['importFile' => 'ไม่สามารถนำเข้าข้อมูลได้: ' . $e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new StudentTemplateExport, 'student_template.xlsx');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'username' => 'required|unique:students,username,' . $student->id,
            'first_name_th' => 'required|string',
            'last_name_th' => 'required|string',
            'batch' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'email' => 'nullable|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string',
            'current_address' => 'nullable|string',
            'subdistrict' => 'nullable|string',
            'district' => 'nullable|string',
            'province' => 'nullable|string',
            'zip_code' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        $student->update($validated);

        // Update course_name if course_id changed
        if ($request->filled('course_id')) {
            $course = Course::find($request->course_id);
            if ($course) {
                $student->update(['course_name' => $course->course_name_th]);
            }
        }

        return redirect()->route('students.index')->with('message', 'อัปเดตข้อมูลนักเรียนเรียบร้อยแล้ว');
    }
}
