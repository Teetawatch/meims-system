<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Course;
use App\Imports\SubjectsImport;
use App\Exports\SubjectTemplateExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchCourse = $request->input('searchCourse');

        $subjects = Subject::query()
            ->with(['course', 'teachers'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('subject_code', 'like', '%' . $search . '%')
                        ->orWhere('subject_name_th', 'like', '%' . $search . '%')
                        ->orWhere('subject_name_en', 'like', '%' . $search . '%');
                });
            })
            ->when($searchCourse, function ($query) use ($searchCourse) {
                $query->where('course_id', $searchCourse);
            })
            ->orderBy('subject_code', 'asc')
            ->paginate(10);

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();
        $allTeachers = \App\Models\Teacher::where('is_active', true)->orderBy('first_name_th')->get();

        return view('subjects.index', compact('subjects', 'courses', 'allTeachers', 'search', 'searchCourse'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:50|unique:subjects,subject_code',
            'subject_name_th' => 'required|string|max:255',
            'subject_name_en' => 'nullable|string|max:255',
            'credits' => 'required|integer|min:0',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $subject = Subject::create(\Illuminate\Support\Arr::except($validated, ['teacher_ids']));
        
        if ($request->has('teacher_ids')) {
            $subject->teachers()->sync($request->teacher_ids);
        }

        return redirect()->route('subjects.index')->with('message', 'เพิ่มรายวิชาใหม่เรียบร้อยแล้ว');
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:50|unique:subjects,subject_code,' . $subject->id,
            'subject_name_th' => 'required|string|max:255',
            'subject_name_en' => 'nullable|string|max:255',
            'credits' => 'required|integer|min:0',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $subject->update(\Illuminate\Support\Arr::except($validated, ['teacher_ids']));
        
        $subject->teachers()->sync($request->teacher_ids ?? []);

        return redirect()->route('subjects.index')->with('message', 'อัปเดตข้อมูลรายวิชาเรียบร้อยแล้ว');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('message', 'ข้อมูลรายวิชาถูกลบเรียบร้อยแล้ว');
    }

    public function import(Request $request)
    {
        $request->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new SubjectsImport, $request->file('importFile')->getRealPath());
            return redirect()->route('subjects.index')->with('message', 'นำเข้าข้อมูลรายวิชาเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect()->route('subjects.index')->withErrors(['importFile' => 'ไม่สามารถนำเข้าข้อมูลได้ ตรวจสอบรูปแบบไฟล์ให้ถูกต้อง (' . $e->getMessage() . ')']);
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new SubjectTemplateExport, 'subject_template.xlsx');
    }
}
