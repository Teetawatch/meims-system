<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\SurveyTopic;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use Illuminate\Support\Facades\Auth;

class DoSurvey extends Component
{
    public $survey;
    public $answers = []; // question_id => score (1-5)
    public $comment = '';
    public $student;

    public function mount(SurveyTopic $survey)
    {
        $this->student = Auth::guard('student')->user();
        $this->survey = $survey->load('questions');

        // Check if already submitted
        $existingResponse = SurveyResponse::where('survey_topic_id', $this->survey->id)
            ->where('student_id', $this->student->id)
            ->exists();

        if ($existingResponse) {
            session()->flash('error', 'คุณได้ทำแบบสอบถามนี้ไปแล้ว');
            return redirect()->route('student.surveys');
        }

        // Initialize answers
        foreach ($this->survey->questions as $question) {
            $this->answers[$question->id] = '';
        }
    }

    public function save()
    {
        $rules = [];
        $messages = [];

        foreach ($this->survey->questions as $question) {
            $rules['answers.' . $question->id] = 'required|integer|min:1|max:5';
            $messages['answers.' . $question->id . '.required'] = 'กรุณาให้คะแนนข้อนี้';
            $messages['answers.' . $question->id . '.min'] = 'คะแนนต่ำสุดคือ 1';
            $messages['answers.' . $question->id . '.max'] = 'คะแนนสูงสุดคือ 5';
        }
        $rules['comment'] = 'nullable|string|max:1000';

        $this->validate($rules, $messages);

        // Calculate Average Score (rounded to nearest integer as per schema)
        $totalScore = 0;
        $count = count($this->answers);
        if ($count > 0) {
            $totalScore = array_sum($this->answers) / $count;
        }

        // Create Response
        $response = SurveyResponse::create([
            'survey_topic_id' => $this->survey->id,
            'student_id' => $this->student->id,
            'score' => round($totalScore),
            'comment' => $this->comment,
        ]);

        // Save Answers
        foreach ($this->answers as $questionId => $value) {
            SurveyAnswer::create([
                'survey_response_id' => $response->id,
                'survey_question_id' => $questionId,
                'score' => (int) $value,
            ]);
        }

        // Dispatch event instead of redirecting immediately
        $this->dispatch('survey-completed');
    }

    public function render()
    {
        return view('components.student.do-survey')
            ->layout('components.layouts.student', ['title' => $this->survey->title]);
    }
}
