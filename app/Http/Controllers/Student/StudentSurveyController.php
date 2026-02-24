<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SurveyTopic;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentSurveyController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        
        $surveys = SurveyTopic::where('is_active', true)
            ->where(function ($query) use ($student) {
                $query->whereNull('course_id')
                      ->orWhere('course_id', $student->course_id);
            })
            ->latest()
            ->get();
            
        $completedSurveyIds = SurveyResponse::where('student_id', $student->id)
            ->pluck('survey_topic_id')
            ->toArray();

        return view('student.surveys', compact('surveys', 'completedSurveyIds'));
    }

    public function show(SurveyTopic $survey)
    {
        $student = Auth::guard('student')->user();
        $survey->load('questions');

        // Check if already submitted
        $existingResponse = SurveyResponse::where('survey_topic_id', $survey->id)
            ->where('student_id', $student->id)
            ->exists();

        if ($existingResponse) {
            return redirect()->route('student.surveys')->with('error', 'คุณได้ทำแบบสอบถามนี้ไปแล้ว');
        }

        return view('student.do-survey', compact('survey'));
    }

    public function store(Request $request, SurveyTopic $survey)
    {
        $student = Auth::guard('student')->user();
        
        $rules = [];
        $messages = [];

        foreach ($survey->questions as $question) {
            $rules['answers.' . $question->id] = 'required|integer|min:1|max:5';
            $messages['answers.' . $question->id . '.required'] = 'กรุณาให้คะแนนข้อนี้';
            $messages['answers.' . $question->id . '.integer'] = 'รูปแบบคะแนนไม่ถูกต้อง';
            $messages['answers.' . $question->id . '.min'] = 'คะแนนต่ำสุดคือ 1';
            $messages['answers.' . $question->id . '.max'] = 'คะแนนสูงสุดคือ 5';
        }
        $rules['comment'] = 'nullable|string|max:1000';

        $validated = $request->validate($rules, $messages);

        $answers = $validated['answers'] ?? [];
        $comment = $validated['comment'] ?? '';

        // Calculate Average Score
        $totalScore = 0;
        $count = count($answers);
        if ($count > 0) {
            $totalScore = array_sum($answers) / $count;
        }

        // Create Response
        $response = SurveyResponse::create([
            'survey_topic_id' => $survey->id,
            'student_id' => $student->id,
            'score' => round($totalScore),
            'comment' => $comment,
        ]);

        // Save Answers
        foreach ($answers as $questionId => $value) {
            SurveyAnswer::create([
                'survey_response_id' => $response->id,
                'survey_question_id' => $questionId,
                'score' => (int) $value,
            ]);
        }

        return redirect()->route('student.surveys')->with('success', 'บันทึกแบบสอบถามเรียบร้อยแล้ว');
    }
}
