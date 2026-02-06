<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SurveyTopic;
use App\Models\SurveyQuestion;

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

    // Results View
    public $selectedTopic;


    protected $listeners = ['deleteSurvey' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['topicId', 'title', 'description', 'is_active', 'questions']);
        $this->questions = ['']; // Start with one empty question
        $this->viewState = 'create';
    }

    public function edit($id)
    {
        $topic = SurveyTopic::with('questions')->findOrFail($id);
        $this->topicId = $id;
        $this->title = $topic->title;
        $this->description = $topic->description;
        $this->is_active = $topic->is_active;

        $this->questions = $topic->questions->pluck('question_text')->toArray();
        if (empty($this->questions)) {
            $this->questions = [''];
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
        $this->reset(['topicId', 'title', 'description', 'is_active', 'selectedTopic', 'questions']);
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

            // Sync questions: Delete old and create new (Simple approach)
            // Ideally we should update existing IDs to preserve data integrity if questions are just edited.
            // But for simplicity in this iteration:
            // Check if we can just update existing ones and add new ones.
            // If we delete all, we lose connection to answers if logic depends on question_id. 
            // However, previous prompt implies this is a new feature request so old data might not be compatible anyway.
            // Let's try to be smart: Get existing questions.

            $existingQuestions = $topic->questions;

            // Loop through input questions
            foreach ($this->questions as $index => $qText) {
                if (isset($existingQuestions[$index])) {
                    $existingQuestions[$index]->update(['question_text' => $qText]);
                } else {
                    $topic->questions()->create(['question_text' => $qText]);
                }
            }

            // Delete extra questions if any
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
            ->withCount('responses') // Optimization
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('components.survey-management', [
            'topics' => $topics
        ])->layout('components.layouts.app');
    }
}
