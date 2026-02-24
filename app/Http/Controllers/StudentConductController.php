<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ConductScore;
use Illuminate\Http\Request;

class StudentConductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $studentId = $request->input('student_id');

        $searchResults = collect();
        if (strlen($search) > 1) {
            $searchResults = Student::query()
                ->where('student_id', 'like', '%' . $search . '%')
                ->orWhere('first_name_th', 'like', '%' . $search . '%')
                ->orWhere('last_name_th', 'like', '%' . $search . '%')
                ->take(5)
                ->get();
        }

        $selectedStudent = null;
        if ($studentId) {
            $selectedStudent = Student::with([
                'conductScores' => function ($q) {
                    $q->latest();
                }
            ])->find($studentId);
        }

        return view('students.conduct', compact('searchResults', 'selectedStudent', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'score_amount' => 'required|integer|min:1',
            'description' => 'required|string',
            'score_type' => 'required|in:deduction,reward',
        ]);

        $finalScore = $request->score_type === 'deduction' ? -abs($request->score_amount) : abs($request->score_amount);

        ConductScore::create([
            'student_id' => $request->student_id,
            'score' => $finalScore,
            'type' => $request->score_type,
            'description' => $request->description,
            'recorded_by' => auth()->user()->name ?? 'Admin',
        ]);

        return redirect()->route('students.conduct', ['student_id' => $request->student_id])
            ->with('message', 'บันทึกคะแนนความประพฤติเรียบร้อยแล้ว');
    }

    public function destroy(Request $request, $id)
    {
        $score = ConductScore::findOrFail($id);
        $studentId = $score->student_id;
        $score->delete();

        return redirect()->route('students.conduct', ['student_id' => $studentId])
            ->with('message', 'ลบรายการคะแนนเรียบร้อยแล้ว');
    }
}
