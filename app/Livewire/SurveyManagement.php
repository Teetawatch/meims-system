<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SurveyTopic;
use App\Models\SurveyQuestion;
use App\Models\Course;

class SurveyManagement extends Component
{
    use WithPagination;

    // View state: 'list', 'create', 'edit', 'results'
    public $viewState = 'list';
    public $search = '';

    // Form fields
    public $topicId;
    public $title;
    public $description;
    public $is_active = true;
    public $questions = []; // Array of question strings
    public $selectedCourses = []; // Array of course IDs
    public $allCourses = true; // When true, survey is for all courses

    // Results View
    public $selectedTopic;


    protected $listeners = ['deleteSurvey' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['topicId', 'title', 'description', 'is_active', 'questions', 'selectedCourses', 'allCourses']);
        $this->questions = ['']; // Start with one empty question
        $this->allCourses = true;
        $this->selectedCourses = [];
        $this->viewState = 'create';
    }

    public function edit($id)
    {
        $topic = SurveyTopic::with(['questions', 'courses'])->findOrFail($id);
        $this->topicId = $id;
        $this->title = $topic->title;
        $this->description = $topic->description;
        $this->is_active = $topic->is_active;

        $this->questions = $topic->questions->pluck('question_text')->toArray();
        if (empty($this->questions)) {
            $this->questions = [''];
        }

        // Load assigned courses
        $courseIds = $topic->courses->pluck('id')->toArray();
        if (empty($courseIds)) {
            $this->allCourses = true;
            $this->selectedCourses = [];
        } else {
            $this->allCourses = false;
            $this->selectedCourses = array_map('strval', $courseIds);
        }

        $this->viewState = 'edit';
    }

    public function addQuestion()
    {
        $this->questions[] = '';
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function cancel()
    {
        $this->reset(['topicId', 'title', 'description', 'is_active', 'selectedTopic', 'questions', 'selectedCourses', 'allCourses']);
        $this->viewState = 'list';
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions.*' => 'required|string|distinct|min:3',
        ], [
            'questions.*.required' => 'กรุณาระบุคำถาม',
            'questions.*.min' => 'คำถามต้องยาวอย่างน้อย 3 ตัวอักษร',
        ]);

        if ($this->viewState === 'edit') {
            $topic = SurveyTopic::findOrFail($this->topicId);
            $topic->update([
                'title' => $this->title,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            $existingQuestions = $topic->questions;

            foreach ($this->questions as $index => $qText) {
                if (isset($existingQuestions[$index])) {
                    $existingQuestions[$index]->update(['question_text' => $qText]);
                } else {
                    $topic->questions()->create(['question_text' => $qText]);
                }
            }

            if ($existingQuestions->count() > count($this->questions)) {
                $toDelete = $existingQuestions->slice(count($this->questions));
                foreach ($toDelete as $model) {
                    $model->delete();
                }
            }

            $message = 'อัปเดตแบบสอบถามเรียบร้อยแล้ว';
        } else {
            $topic = SurveyTopic::create([
                'title' => $this->title,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            foreach ($this->questions as $qText) {
                $topic->questions()->create(['question_text' => $qText]);
            }

            $message = 'สร้างแบบสอบถามใหม่เรียบร้อยแล้ว';
        }

        // Sync courses
        if ($this->allCourses) {
            $topic->courses()->detach(); // No restriction = all courses
        } else {
            $topic->courses()->sync(array_map('intval', $this->selectedCourses));
        }

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => $message
        ]);

        $this->cancel(); // Return to list
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'คุณแน่ใจหรือไม่?',
            'text' => 'หากลบแบบสอบถามนี้ ข้อมูลผลการประเมินทั้งหมดจะหายไป!',
            'method' => 'deleteSurvey',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        SurveyTopic::find($id)->delete();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ลบสำเร็จ!',
            'text' => 'ลบแบบสอบถามเรียบร้อยแล้ว'
        ]);
    }

    public function viewResults($id)
    {
        $this->selectedTopic = SurveyTopic::with([
            'questions.answers',
            'responses' => function ($q) {
                $q->latest();
            }
        ])->findOrFail($id);

        $this->viewState = 'results';
    }

    public function render()
    {
        $topics = SurveyTopic::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->with('courses')
            ->withCount('responses')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();

        return view('components.survey-management', [
            'topics' => $topics,
            'courses' => $courses,
        ])->layout('components.layouts.app');
    }
}
