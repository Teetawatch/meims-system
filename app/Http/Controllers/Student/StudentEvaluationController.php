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

        // Check if teacher evaluation is enabled
        $teacherEvaluationEnabled = SystemSetting::isTeacherEvaluationEnabled();

        // Find subjects in student's course
        $subjects = collect();
        if ($teacherEvaluationEnabled) {
            $subjects = Subject::where('course_id', $student->course_id)
                ->where('is_active', true)
                ->with('teachers')
                ->get();
        }

        // Check which have been evaluated
        $evaluatedTeachers = TeacherEvaluationModel::where('student_id', $student->id)
            ->get()
            ->map(function($ev) { return $ev->subject_id . '_' . $ev->teacher_id; })
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

        return view('student.evaluation', compact('subjects', 'evaluatedTeachers', 'classmates', 'evaluatedPeers', 'peerEvaluationEnabled', 'teacherEvaluationEnabled'));
    }

    public function teacherEvaluation($subjectId, $teacherId)
    {
        $subject = Subject::findOrFail($subjectId);
        $teacher = \App\Models\Teacher::findOrFail($teacherId);

        // Check if already evaluated
        $studentId = Auth::guard('student')->id();
        $exists = TeacherEvaluationModel::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->exists();

        if ($exists) {
            return redirect()->route('student.evaluation')->with('error', 'คุณได้ทำการประเมินวิชานี้กับอาจารย์ท่านนี้ไปแล้ว');
        }

        return view('student.teacher-evaluation', compact('subject', 'subjectId', 'teacher', 'teacherId'));
    }

    public function storeTeacherEvaluation(Request $request, $subjectId, $teacherId)
    {
        $subject = Subject::findOrFail($subjectId);
        $teacher = \App\Models\Teacher::findOrFail($teacherId);

        $request->validate([
            'rating_knowledge'     => 'required|integer|min:1|max:5', // ข้อ 1
            'rating_method'        => 'required|integer|min:1|max:5', // ข้อ 2
            'rating_content_order' => 'required|integer|min:1|max:5', // ข้อ 3
            'rating_motivation'    => 'required|integer|min:1|max:5', // ข้อ 4
            'rating_qa'            => 'required|integer|min:1|max:5', // ข้อ 5
            'rating_media'         => 'required|integer|min:1|max:5', // ข้อ 6
            'rating_documents'     => 'required|integer|min:1|max:5', // ข้อ 7
            'comment'              => 'nullable|string|max:2000',
            'problems_suggestions' => 'nullable|string|max:2000',
        ]);

        TeacherEvaluationModel::create([
            'student_id'           => Auth::guard('student')->id(),
            'teacher_id'           => $teacher->id,
            'subject_id'           => $subjectId,
            'semester'             => '1/2567',
            'rating_knowledge'     => $request->rating_knowledge,
            'rating_method'        => $request->rating_method,
            'rating_content_order' => $request->rating_content_order,
            'rating_motivation'    => $request->rating_motivation,
            'rating_qa'            => $request->rating_qa,
            'rating_media'         => $request->rating_media,
            'rating_documents'     => $request->rating_documents,
            'comment'              => $request->comment,
            'problems_suggestions' => $request->problems_suggestions,
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
