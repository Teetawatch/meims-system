<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $timetables = Timetable::query()
            ->with('course')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('course_name_th', 'like', '%' . $search . '%')
                            ->orWhere('course_code', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();

        return view('timetables.index', compact('timetables', 'courses', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'is_active' => 'boolean',
            'pdfFile' => 'required|file|mimes:pdf|max:10240',
        ]);

        $filePath = $request->file('pdfFile')->store('timetables', 'public');

        Timetable::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'is_active' => $request->has('is_active'),
            'file_path' => $filePath,
        ]);

        return redirect()->route('timetables.index')->with('success', 'เพิ่มตารางเรียนเรียบร้อยแล้ว');
    }

    public function update(Request $request, Timetable $timetable)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'is_active' => 'boolean',
            'pdfFile' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $filePath = $timetable->file_path;
        if ($request->hasFile('pdfFile')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('pdfFile')->store('timetables', 'public');
        }

        $timetable->update([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'is_active' => $request->has('is_active'),
            'file_path' => $filePath,
        ]);

        return redirect()->route('timetables.index')->with('success', 'อัปเดตตารางเรียนเรียบร้อยแล้ว');
    }

    public function destroy(Timetable $timetable)
    {
        if ($timetable->file_path) {
            Storage::disk('public')->delete($timetable->file_path);
        }
        $timetable->delete();

        return redirect()->route('timetables.index')->with('success', 'ลบตารางเรียนเรียบร้อยแล้ว');
    }
}
