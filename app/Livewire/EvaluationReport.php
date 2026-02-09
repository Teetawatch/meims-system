<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use App\Models\TeacherEvaluation;
use App\Models\PeerEvaluation;
use App\Models\Student;
use App\Models\SystemSetting;

class EvaluationReport extends Component
{
    public $type = 'teacher'; // teacher or peer
    public $peerEvaluationEnabled = false;

    public function mount()
    {
        $this->peerEvaluationEnabled = SystemSetting::isPeerEvaluationEnabled();
    }

    public function togglePeerEvaluation()
    {
        $this->peerEvaluationEnabled = !$this->peerEvaluationEnabled;
        SystemSetting::set('peer_evaluation_enabled', $this->peerEvaluationEnabled ? '1' : '0');
    }

    public function render()
    {
        if ($this->type == 'teacher') {
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

        return view('components.evaluation-report', [
            'reportData' => $reportData
        ])->layout('components.layouts.app');
    }
}
