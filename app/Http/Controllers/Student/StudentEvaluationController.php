<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\TeacherEvaluation as TeacherEvaluationModel;
use App\Models\PeerEvaluation as PeerEvaluationModel;
use App\Models\Student;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentEvaluationController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        // Find subjects in student's course
        $subjects = Subject::where('course_id', $student->course_id)
            ->where('is_active', true)
            ->with('teacher')
            ->get();

        // Check which have been evaluated
        $evaluatedTeachers = TeacherEvaluationModel::where('student_id', $student->id)
            ->pluck('subject_id')
            ->toArray();

        // Check if peer evaluation is enabled by admin
        $peerEvaluationEnabled = SystemSetting::isPeerEvaluationEnabled();

        $classmates = collect();
        $evaluatedPeers = [];

        if ($peerEvaluationEnabled) {
            // Peer evaluation: usually done per semester for all classmates
            $classmates = Student::where('course_id', $student->course_id)
                ->where('batch', $student->batch)
                ->where('id', '!=', $student->id) // Cannot evaluate self
                ->get();

            $evaluatedPeers = PeerEvaluationModel::where('student_id', $student->id)
                ->pluck('target_student_id')
                ->toArray();
        }

        return view('student.evaluation', compact('subjects', 'evaluatedTeachers', 'classmates', 'evaluatedPeers', 'peerEvaluationEnabled'));
    }

    public function teacherEvaluation($subjectId)
    {
        $subject = Subject::with('teacher')->findOrFail($subjectId);

        // Check if already evaluated
        $studentId = Auth::guard('student')->id();
        $exists = TeacherEvaluationModel::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->exists();

        if ($exists) {
            return redirect()->route('student.evaluation')->with('error', 'คุณได้ทำการประเมินวิชานี้ไปแล้ว');
        }

        return view('student.teacher-evaluation', compact('subject', 'subjectId'));
    }

    public function storeTeacherEvaluation(Request $request, $subjectId)
    {
        $subject = Subject::findOrFail($subjectId);

        $request->validate([
            'rating_knowledge' => 'required|integer|min:1|max:5',
            'rating_method' => 'required|integer|min:1|max:5',
            'rating_attitude' => 'required|integer|min:1|max:5',
            'rating_timeliness' => 'required|integer|min:1|max:5',
            'rating_support' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        TeacherEvaluationModel::create([
            'student_id' => Auth::guard('student')->id(),
            'teacher_id' => $subject->teacher_id,
            'subject_id' => $subjectId,
            'semester' => '1/2567', // Should be dynamic depending on settings
            'rating_knowledge' => $request->rating_knowledge,
            'rating_method' => $request->rating_method,
            'rating_attitude' => $request->rating_attitude,
            'rating_timeliness' => $request->rating_timeliness,
            'rating_support' => $request->rating_support,
            'comment' => $request->comment,
        ]);

        return redirect()->route('student.evaluation')->with('success', 'ส่งผลการประเมินเรียบร้อยแล้ว');
    }

    public function peerEvaluation($studentId)
    {
        // Check if peer evaluation is enabled by admin
        if (!SystemSetting::isPeerEvaluationEnabled()) {
            return redirect()->route('student.evaluation')->with('error', 'ระบบประเมินเพื่อนร่วมห้องย้งไม่เปิดให้ใช้งาน');
        }

        $targetStudentId = $studentId;
        $targetStudent = Student::findOrFail($studentId);

        $myId = Auth::guard('student')->id();

        if ($studentId == $myId) {
            return redirect()->route('student.evaluation')->with('error', 'คุณไม่สามารถประเมินตัวเองได้');
        }

        // Check if already evaluated
        $exists = PeerEvaluationModel::where('student_id', $myId)
            ->where('target_student_id', $studentId)
            ->exists();

        if ($exists) {
            return redirect()->route('student.evaluation')->with('error', 'คุณได้ทำการประเมินเพื่อนคนนี้ไปแล้ว');
        }

        return view('student.peer-evaluation', compact('targetStudent', 'targetStudentId'));
    }

    public function storePeerEvaluation(Request $request, $studentId)
    {
        $request->validate([
            'rating_contribution' => 'required|integer|min:1|max:5',
            'rating_responsibility' => 'required|integer|min:1|max:5',
            'rating_teamwork' => 'required|integer|min:1|max:5',
            'rating_interpersonal' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        PeerEvaluationModel::create([
            'student_id' => Auth::guard('student')->id(),
            'target_student_id' => $studentId,
            'subject_id' => 1, // Placeholder if no specific subject
            'semester' => '1/2567',
            'rating_contribution' => $request->rating_contribution,
            'rating_responsibility' => $request->rating_responsibility,
            'rating_teamwork' => $request->rating_teamwork,
            'rating_interpersonal' => $request->rating_interpersonal,
            'comment' => $request->comment,
        ]);

        return redirect()->route('student.evaluation')->with('success', 'ส่งผลการประเมินเพื่อนเรียบร้อยแล้ว');
    }
}
