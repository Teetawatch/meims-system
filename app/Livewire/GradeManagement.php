<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Course;
use App\Imports\GradesImport;
use App\Exports\GradeTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class GradeManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $courseFilter = '';
    public $batchFilter = '';
    public $yearFilter = '';
    public $semesterFilter = '';

    public function downloadTemplate()
    {
        return Excel::download(new GradeTemplateExport, 'grade_template.xlsx');
    }

    public $isModalOpen = false;
    public $isImportModalOpen = false;

    // Form fields
    public $gradeId;
    public $student_id;
    public $subject_id;
    public $semester;
    public $score;
    public $grade_value; // named grade_value to avoid conflict with model name

    // Import fields
    public $importFile;
    public $importSemester;

    protected $listeners = ['deleteGrade' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['gradeId', 'student_id', 'subject_id', 'semester', 'score', 'grade_value']);
        $this->isModalOpen = true;
    }

    public function openImportModal()
    {
        $this->resetValidation();
        $this->reset(['importFile', 'importSemester']);
        $this->isImportModalOpen = true;
    }

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $this->gradeId = $id;
        $this->student_id = $grade->student_id;
        $this->subject_id = $grade->subject_id;
        $this->semester = $grade->semester;
        $this->score = $grade->score;
        $this->grade_value = $grade->grade;

        $this->isModalOpen = true;
    }

    public function save()
    {
        $allowedGrades = ['0', '1', '1.5', '2', '2.5', '3', '3.5', '4'];

        $this->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string',
            'score' => 'nullable|numeric|min:0|max:100',
            'grade_value' => [
                'nullable',
                Rule::in($allowedGrades),
            ],
        ], [
            'grade_value.in' => 'เกรดต้องเป็น 0, 1, 1.5, 2, 2.5, 3, 3.5 หรือ 4 เท่านั้น',
        ]);

        $data = [
            'student_id' => $this->student_id,
            'subject_id' => $this->subject_id,
            'semester' => $this->semester,
            'score' => $this->score,
            'grade' => $this->grade_value,
        ];

        if ($this->gradeId) {
            Grade::find($this->gradeId)->update($data);
        } else {
            Grade::create($data);
        }

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'สำเร็จ!',
            'text' => 'บันทึกเกรดเรียบร้อยแล้ว'
        ]);

        $this->isModalOpen = false;
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls',
            'importSemester' => 'required|string',
        ]);

        try {
            Excel::import(new GradesImport($this->importSemester), $this->importFile);

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'นำเข้าสำเร็จ!',
                'text' => 'นำเข้าข้อมูลเกรดนักเรียนเรียบร้อยแล้ว'
            ]);

            $this->isImportModalOpen = false;
        } catch (\Exception $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'เกิดข้อผิดพลาด!',
                'text' => 'ไม่สามารถนำเข้าข้อมูลได้: ' . $e->getMessage()
            ]);
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'คุณแน่ใจหรือไม่?',
            'text' => 'ข้อมูลเกรดนี้จะถูกลบออกจากระบบ!',
            'method' => 'deleteGrade',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Grade::destroy($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ลบสำเร็จ!',
            'text' => 'ลบข้อมูลเกรดเรียบร้อยแล้ว'
        ]);
    }

    public function render()
    {
        $grades = Grade::query()
            ->with(['student.course', 'subject'])
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('first_name_th', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name_th', 'like', '%' . $this->search . '%')
                        ->orWhere('student_id', 'like', '%' . $this->search . '%');
                })->orWhereHas('subject', function ($q) {
                    $q->where('subject_name_th', 'like', '%' . $this->search . '%')
                        ->orWhere('subject_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->courseFilter, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('course_id', $this->courseFilter);
                });
            })
            ->when($this->batchFilter, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('batch', $this->batchFilter);
                });
            })
            ->when($this->yearFilter, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('fiscal_year', $this->yearFilter);
                });
            })
            ->when($this->semesterFilter, function ($query) {
                $query->where('semester', $this->semesterFilter);
            })
            ->latest()
            ->paginate(15);

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();
        $subjects = Subject::orderBy('subject_code')->get();
        $students = Student::orderBy('student_id')->get();

        // Distinct values for filters
        $batches = Student::distinct()->pluck('batch');
        $years = Student::distinct()->pluck('fiscal_year');
        $semesters = Grade::distinct()->pluck('semester');

        $allowedGrades = ['0', '1', '1.5', '2', '2.5', '3', '3.5', '4'];

        return view('components.grade-management', [
            'grades' => $grades,
            'courses' => $courses,
            'subjects' => $subjects,
            'students' => $students,
            'batches' => $batches,
            'years' => $years,
            'semesters' => $semesters,
            'allowedGrades' => $allowedGrades,
        ])->layout('components.layouts.app');
    }
}
