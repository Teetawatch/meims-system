<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherEvaluation;
use App\Models\PeerEvaluation;
use App\Models\SystemSetting;
use App\Exports\StudentReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function students(Request $request)
    {
        $fiscal_year = $request->input('fiscal_year');
        $batch = $request->input('batch');
        $course_name = $request->input('course_name');

        $fiscal_years = Student::select('fiscal_year')->distinct()->orderBy('fiscal_year', 'desc')->pluck('fiscal_year');
        $batches = Student::select('batch')->distinct()->orderBy('batch', 'desc')->pluck('batch');
        $courses = Student::select('course_name')->distinct()->orderBy('course_name')->pluck('course_name');

        $query = Student::query();

        if ($fiscal_year) {
            $query->where('fiscal_year', $fiscal_year);
        }

        if ($batch) {
            $query->where('batch', $batch);
        }

        if ($course_name) {
            $query->where('course_name', $course_name);
        }

        $students = $query->paginate(10)->withQueryString();

        return view('reports.students', compact('students', 'fiscal_years', 'batches', 'courses', 'fiscal_year', 'batch', 'course_name'));
    }

    public function exportStudents(Request $request)
    {
        $filters = [
            'fiscal_year' => $request->input('fiscal_year'),
            'batch' => $request->input('batch'),
            'course_name' => $request->input('course_name'),
        ];

        return Excel::download(new StudentReportExport($filters), 'student_report_' . date('Y-m-d') . '.xlsx');
    }

    public function evaluations(Request $request)
    {
        $type = $request->input('type', 'teacher'); // teacher or peer
        $peerEvaluationEnabled = SystemSetting::isPeerEvaluationEnabled();
        $teacherEvaluationEnabled = SystemSetting::isTeacherEvaluationEnabled();

        if ($type == 'teacher') {
            $reportData = Teacher::withCount('evaluations')
                ->get()
                ->map(function ($teacher) {
                    $evals = $teacher->evaluations;
                    $teacher->avg_knowledge = $evals->avg('rating_knowledge') ?: 0;
                    $teacher->avg_method = $evals->avg('rating_method') ?: 0;
                    $teacher->avg_attitude = $evals->avg('rating_attitude') ?: 0;
                    $teacher->avg_timeliness = $evals->avg('rating_timeliness') ?: 0;
                    $teacher->avg_support = $evals->avg('rating_support') ?: 0;
                    $teacher->overall_avg = ($teacher->avg_knowledge + $teacher->avg_method + $teacher->avg_attitude + $teacher->avg_timeliness + $teacher->avg_support) / 5;
                    return $teacher;
                });
        } else {
            $reportData = Student::has('peerEvaluationsAsTarget')
                ->withCount('peerEvaluationsAsTarget as evaluations_count')
                ->get()
                ->map(function ($student) {
                    $evals = PeerEvaluation::where('target_student_id', $student->id)->get();
                    $student->avg_contribution = $evals->avg('rating_contribution') ?: 0;
                    $student->avg_responsibility = $evals->avg('rating_responsibility') ?: 0;
                    $student->avg_teamwork = $evals->avg('rating_teamwork') ?: 0;
                    $student->overall_avg = ($student->avg_contribution + $student->avg_responsibility + $student->avg_teamwork) / 3;
                    return $student;
                });
        }

        return view('reports.evaluations', compact('reportData', 'type', 'peerEvaluationEnabled', 'teacherEvaluationEnabled'));
    }

    public function togglePeerSetting(Request $request)
    {
        $enabled = $request->input('enabled');
        $type = $request->input('type', 'peer');
        
        if ($type == 'teacher') {
            SystemSetting::set('teacher_evaluation_enabled', $enabled ? '1' : '0');
            return redirect()->route('reports.evaluations', ['type' => 'teacher'])->with('success', 'สถานะการประเมินอาจารย์อัปเดตแล้ว');
        } else {
            SystemSetting::set('peer_evaluation_enabled', $enabled ? '1' : '0');
            return redirect()->route('reports.evaluations', ['type' => 'peer'])->with('success', 'สถานะการประเมินเพื่อนอัปเดตแล้ว');
        }
    }
}
