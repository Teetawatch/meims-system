<?php

namespace App\Http\Controllers;

use App\Models\SurveyTopic;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $topics = SurveyTopic::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->withCount('responses')
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('surveys.index', compact('topics', 'search'));
    }

    public function create()
    {
        $courses = \App\Models\Course::where('is_active', true)->orderBy('course_name_th')->get();
        return view('surveys.form', ['topic' => new SurveyTopic(), 'isEdit' => false, 'courses' => $courses]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'questions' => 'required|array',
            'questions.*' => 'required|string|distinct|min:3',
        ], [
            'questions.*.required' => 'กรุณาระบุคำถาม',
            'questions.*.min' => 'คำถามต้องยาวอย่างน้อย 3 ตัวอักษร',
        ]);

        $topic = SurveyTopic::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($request->questions as $qText) {
            $topic->questions()->create(['question_text' => $qText]);
        }

        return redirect()->route('surveys.index')->with('success', 'สร้างแบบสอบถามใหม่เรียบร้อยแล้ว');
    }

    public function edit(SurveyTopic $survey)
    {
        $survey->load('questions');
        $courses = \App\Models\Course::where('is_active', true)->orderBy('course_name_th')->get();
        return view('surveys.form', ['topic' => $survey, 'isEdit' => true, 'courses' => $courses]);
    }

    public function update(Request $request, SurveyTopic $survey)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'questions' => 'required|array',
            'questions.*' => 'required|string|distinct|min:3',
        ], [
            'questions.*.required' => 'กรุณาระบุคำถาม',
            'questions.*.min' => 'คำถามต้องยาวอย่างน้อย 3 ตัวอักษร',
        ]);

        $survey->update([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'is_active' => $request->has('is_active'),
        ]);

        $existingQuestions = $survey->questions;
        $inputQuestions = array_values($request->questions);

        foreach ($inputQuestions as $index => $qText) {
            if (isset($existingQuestions[$index])) {
                $existingQuestions[$index]->update(['question_text' => $qText]);
            } else {
                $survey->questions()->create(['question_text' => $qText]);
            }
        }

        if ($existingQuestions->count() > count($inputQuestions)) {
            $toDelete = $existingQuestions->slice(count($inputQuestions));
            foreach ($toDelete as $model) {
                $model->delete();
            }
        }

        return redirect()->route('surveys.index')->with('success', 'อัปเดตแบบสอบถามเรียบร้อยแล้ว');
    }

    public function destroy(SurveyTopic $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('success', 'ลบแบบสอบถามเรียบร้อยแล้ว');
    }

    public function show(SurveyTopic $survey)
    {
        $survey->load([
            'questions.answers',
            'responses' => function ($q) {
                $q->latest();
            }
        ]);

        // Calculate averages for view if needed. Note: The model seems to have an accessor for average_score and total_responses.
        // Let's pass it anyway.
        return view('surveys.show', ['selectedTopic' => $survey]);
    }
}
