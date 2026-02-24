<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Course;
use App\Imports\GradesImport;
use App\Exports\GradeTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $courseFilter = $request->input('courseFilter');
        $batchFilter = $request->input('batchFilter');
        $yearFilter = $request->input('yearFilter');
        $semesterFilter = $request->input('semesterFilter');

        $grades = Grade::query()
            ->with(['student.course', 'subject'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('first_name_th', 'like', '%' . $search . '%')
                        ->orWhere('last_name_th', 'like', '%' . $search . '%')
                        ->orWhere('student_id', 'like', '%' . $search . '%');
                })->orWhereHas('subject', function ($q) use ($search) {
                    $q->where('subject_name_th', 'like', '%' . $search . '%')
                        ->orWhere('subject_code', 'like', '%' . $search . '%');
                });
            })
            ->when($courseFilter, function ($query) use ($courseFilter) {
                $query->whereHas('student', function ($q) use ($courseFilter) {
                    $q->where('course_id', $courseFilter);
                });
            })
            ->when($batchFilter, function ($query) use ($batchFilter) {
                $query->whereHas('student', function ($q) use ($batchFilter) {
                    $q->where('batch', $batchFilter);
                });
            })
            ->when($yearFilter, function ($query) use ($yearFilter) {
                $query->whereHas('student', function ($q) use ($yearFilter) {
                    $q->where('fiscal_year', $yearFilter);
                });
            })
            ->when($semesterFilter, function ($query) use ($semesterFilter) {
                $query->where('semester', $semesterFilter);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();
        $subjects = Subject::orderBy('subject_code')->get();
        $students = Student::orderBy('student_id')->get();

        $batches = Student::distinct()->pluck('batch')->filter();
        $years = Student::distinct()->pluck('fiscal_year')->filter();
        $semesters = Grade::distinct()->pluck('semester')->filter();

        $allowedGrades = ['0', '1', '1.5', '2', '2.5', '3', '3.5', '4', 'A', 'B+', 'B', 'C+', 'C', 'D+', 'D', 'F', 'S', 'U']; // Added letters just in case, based on UI

        return view('grades.index', compact(
            'grades', 'courses', 'subjects', 'students', 'batches', 'years', 'semesters', 'allowedGrades',
            'search', 'courseFilter', 'batchFilter', 'yearFilter', 'semesterFilter'
        ));
    }

    public function store(Request $request)
    {
        // $allowedGrades = ['0', '1', '1.5', '2', '2.5', '3', '3.5', '4', 'A', 'B+', 'B', 'C+', 'C', 'D+', 'D', 'F', 'S', 'U'];

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string',
            'score' => 'nullable|numeric|min:0|max:100',
            'grade_value' => 'nullable|string'
        ]);

        $data = [
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'semester' => $request->semester,
            'score' => $request->score,
            'grade' => $request->grade_value,
        ];

        Grade::create($data);

        return redirect()->route('grades.index')->with('success', 'บันทึกเกรดเรียบร้อยแล้ว');
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string',
            'score' => 'nullable|numeric|min:0|max:100',
            'grade_value' => 'nullable|string'
        ]);

        $grade->update([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'semester' => $request->semester,
            'score' => $request->score,
            'grade' => $request->grade_value,
        ]);

        return redirect()->route('grades.index')->with('success', 'บันทึกเกรดเรียบร้อยแล้ว');
    }

    public function import(Request $request)
    {
        $request->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv',
            'importSemester' => 'required|string',
        ]);

        try {
            Excel::import(new GradesImport($request->importSemester), $request->file('importFile'));
            return redirect()->route('grades.index')->with('success', 'นำเข้าข้อมูลเกรดนักเรียนเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->withErrors(['importFile' => 'ไม่สามารถนำเข้าข้อมูลได้: ' . $e->getMessage()]);
        }
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'ลบข้อมูลเกรดเรียบร้อยแล้ว');
    }

    public function downloadTemplate()
    {
        return Excel::download(new GradeTemplateExport, 'grade_template.xlsx');
    }
}
