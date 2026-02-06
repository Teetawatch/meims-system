<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Subject;
use App\Models\TeacherEvaluation as TeacherEvaluationModel;
use Illuminate\Support\Facades\Auth;

class TeacherEvaluation extends Component
{
    public $subjectId;
    public $subject;
    public $rating_knowledge = 0;
    public $rating_method = 0;
    public $rating_attitude = 0;
    public $rating_timeliness = 0;
    public $rating_support = 0;
    public $comment = '';

    public function mount($subjectId)
    {
        $this->subjectId = $subjectId;
        $this->subject = Subject::with('teacher')->findOrFail($subjectId);

        // Check if already evaluated
        $studentId = Auth::guard('student')->id();
        $exists = TeacherEvaluation::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->exists();

        if ($exists) {
            session()->flash('error', 'คุณได้ทำการประเมินวิชานี้ไปแล้ว');
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
            'rating_knowledge' => 'required|min:1|max:5',
            'rating_method' => 'required|min:1|max:5',
            'rating_attitude' => 'required|min:1|max:5',
            'rating_timeliness' => 'required|min:1|max:5',
            'rating_support' => 'required|min:1|max:5',
        ]);

        TeacherEvaluationModel::create([
            'student_id' => Auth::guard('student')->id(),
            'teacher_id' => $this->subject->teacher_id,
            'subject_id' => $this->subjectId,
            'semester' => '1/2567', // Should be dynamic
            'rating_knowledge' => $this->rating_knowledge,
            'rating_method' => $this->rating_method,
            'rating_attitude' => $this->rating_attitude,
            'rating_timeliness' => $this->rating_timeliness,
            'rating_support' => $this->rating_support,
            'comment' => $this->comment,
        ]);

        session()->flash('success', 'ส่งผลการประเมินเรียบร้อยแล้ว');
        return redirect()->route('student.evaluation');
    }

    public function render()
    {
        return view('components.student.teacher-evaluation')->layout('components.layouts.student');
    }
}
