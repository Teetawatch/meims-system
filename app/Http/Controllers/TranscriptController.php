<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class TranscriptController extends Controller
{
    public function download(Request $request)
    {
        $query = Student::with(['grades.subject', 'course']);

        if ($request->student_id) {
            $query->where('id', $request->student_id);
        } else {
            if ($request->course_id) {
                $query->where('course_id', $request->course_id);
            }
            if ($request->batch) {
                $query->where('batch', $request->batch);
            }
            if ($request->fiscal_year) {
                $query->where('fiscal_year', $request->fiscal_year);
            }
        }

        $students = $query->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'ไม่พบข้อมูลนักเรียน');
        }

        $pdf = Pdf::loadView('pdf.transcript', ['students' => $students]);

        // Optional: Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('transcript_' . date('Ymd_His') . '.pdf');
    }
}
