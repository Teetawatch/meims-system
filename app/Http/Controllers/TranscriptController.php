<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class TranscriptController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $courseFilter = $request->input('courseFilter');
        $batchFilter = $request->input('batchFilter');
        $yearFilter = $request->input('yearFilter');

        $students = Student::query()
            ->with('course')
            ->when($search, function ($query) use ($search) {
                $query->where('first_name_th', 'like', '%' . $search . '%')
                    ->orWhere('last_name_th', 'like', '%' . $search . '%')
                    ->orWhere('student_id', 'like', '%' . $search . '%');
            })
            ->when($courseFilter, function ($query) use ($courseFilter) {
                $query->where('course_id', $courseFilter);
            })
            ->when($batchFilter, function ($query) use ($batchFilter) {
                $query->where('batch', $batchFilter);
            })
            ->when($yearFilter, function ($query) use ($yearFilter) {
                $query->where('fiscal_year', $yearFilter);
            })
            ->paginate(15)
            ->withQueryString();

        $courses = \App\Models\Course::where('is_active', true)->orderBy('course_name_th')->get();
        $batches = Student::distinct()->pluck('batch');
        $years = Student::distinct()->pluck('fiscal_year');

        return view('transcripts.index', compact('students', 'courses', 'batches', 'years', 'search', 'courseFilter', 'batchFilter', 'yearFilter'));
    }

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
