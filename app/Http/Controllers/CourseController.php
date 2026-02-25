<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $courses = Course::query()
            ->when($search, function ($query, $search) {
                $query->where('course_code', 'like', '%' . $search . '%')
                    ->orWhere('course_name_th', 'like', '%' . $search . '%')
                    ->orWhere('course_name_en', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('courses.index', compact('courses', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:255|unique:courses,course_code',
            'course_name_th' => 'required|string|max:255',
            'course_name_en' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:255',
            'fiscal_year_batch' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Course::create($validated);

        return redirect()->route('courses.index')->with('message', 'เพิ่มหลักสูตรใหม่เรียบร้อยแล้ว');
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:255|unique:courses,course_code,' . $course->id,
            'course_name_th' => 'required|string|max:255',
            'course_name_en' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:255',
            'fiscal_year_batch' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $course->update($validated);

        return redirect()->route('courses.index')->with('message', 'อัปเดตข้อมูลหลักสูตรเรียบร้อยแล้ว');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('message', 'ข้อมูลหลักสูตรถูกลบเรียบร้อยแล้ว');
    }
}
