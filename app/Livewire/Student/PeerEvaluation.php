<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use App\Models\PeerEvaluation as PeerEvaluationModel;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;

class PeerEvaluation extends Component
{
    public $targetStudentId;
    public $targetStudent;
    public $rating_contribution = 0;
    public $rating_responsibility = 0;
    public $rating_teamwork = 0;
    public $rating_interpersonal = 0;
    public $comment = '';

    public function mount($studentId)
    {
        // Check if peer evaluation is enabled by admin
        if (!SystemSetting::isPeerEvaluationEnabled()) {
            session()->flash('error', 'ระบบประเมินเพื่อนร่วมห้องยังไม่เปิดให้ใช้งาน');
            return redirect()->route('student.evaluation');
        }

        $this->targetStudentId = $studentId;
        $this->targetStudent = Student::findOrFail($studentId);

        $myId = Auth::guard('student')->id();

        if ($studentId == $myId) {
            session()->flash('error', 'คุณไม่สามารถประเมินตัวเองได้');
            return redirect()->route('student.evaluation');
        }

        // Check if already evaluated
        $exists = PeerEvaluationModel::where('student_id', $myId)
            ->where('target_student_id', $studentId)
            ->exists();

        if ($exists) {
            session()->flash('error', 'คุณได้ทำการประเมินเพื่อนคนนี้ไปแล้ว');
            return redirect()->route('student.evaluation');
        }
    }

    public function setRating($field, $value)
    {
        $this->$field = $value;
    }

    public function submit()
    {
        $this->validate([
            'rating_contribution' => 'required|min:1|max:5',
            'rating_responsibility' => 'required|min:1|max:5',
            'rating_teamwork' => 'required|min:1|max:5',
            'rating_interpersonal' => 'required|min:1|max:5',
        ]);

        PeerEvaluationModel::create([
            'student_id' => Auth::guard('student')->id(),
            'target_student_id' => $this->targetStudentId,
            'subject_id' => 1, // Placeholder if no specific subject
            'semester' => '1/2567',
            'rating_contribution' => $this->rating_contribution,
            'rating_responsibility' => $this->rating_responsibility,
            'rating_teamwork' => $this->rating_teamwork,
            'rating_interpersonal' => $this->rating_interpersonal,
            'comment' => $this->comment,
        ]);

        session()->flash('success', 'ส่งผลการประเมินเพื่อนเรียบร้อยแล้ว');
        return redirect()->route('student.evaluation');
    }

    public function render()
    {
        return view('components.student.peer-evaluation')->layout('components.layouts.student');
    }
}
