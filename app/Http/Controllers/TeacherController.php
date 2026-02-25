<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Exports\TeacherTemplateExport;
use App\Imports\TeachersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $teachers = Teacher::query()
            ->when($search, function ($query) use ($search) {
                $query->where('first_name_th', 'like', '%' . $search . '%')
                    ->orWhere('last_name_th', 'like', '%' . $search . '%')
                    ->orWhere('teacher_code', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(15);

        return view('teachers.index', compact('teachers', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_code' => 'required|unique:teachers,teacher_code',
            'title_th' => 'nullable|string|max:255',
            'first_name_th' => 'required|string|max:255',
            'last_name_th' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = true;

        Teacher::create($validated);

        return redirect()->route('teachers.index')->with('message', 'บันทึกข้อมูลอาจารย์เรียบร้อยแล้ว');
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'teacher_code' => 'required|unique:teachers,teacher_code,' . $teacher->id,
            'title_th' => 'nullable|string|max:255',
            'first_name_th' => 'required|string|max:255',
            'last_name_th' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('message', 'อัปเดตข้อมูลอาจารย์เรียบร้อยแล้ว');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('message', 'ลบข้อมูลอาจารย์เรียบร้อยแล้ว');
    }

    public function import(Request $request)
    {
        $request->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new TeachersImport, $request->file('importFile'));
            return redirect()->route('teachers.index')->with('message', 'นำเข้าข้อมูลอาจารย์เรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect()->route('teachers.index')->withErrors(['importFile' => 'ไม่สามารถนำเข้าข้อมูลได้: ' . $e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new TeacherTemplateExport, 'teacher_template.xlsx');
    }
}
