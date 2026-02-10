<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function exportStudentPdf(Request $request)
    {
        $fiscal_year = $request->query('fiscal_year');
        $batch = $request->query('batch');
        $course_name = $request->query('course_name');

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

        $students = $query->get();

        $pdf = Pdf::loadView('pdf.student-report', [
            'students' => $students,
            'fiscal_year' => $fiscal_year,
            'batch' => $batch,
            'course_name' => $course_name,
        ]);

        // Setup for Thai font support if needed, usually handled in view CSS
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('student_report_' . date('Y-m-d') . '.pdf');
    }
}
