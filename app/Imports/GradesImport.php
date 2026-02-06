<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class GradesImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $semester;

    public function __construct($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $student = Student::where('student_id', $row['student_id'])->first();
        $subject = Subject::where('subject_code', $row['subject_code'])->first();

        if (!$student || !$subject) {
            return null;
        }

        // Use updateOrCreate to handle existing records
        return Grade::updateOrCreate(
            [
                'student_id' => $student->id,
                'subject_id' => $subject->id,
                'semester' => $this->semester,
            ],
            [
                'score' => $row['score'] ?? null,
                'grade' => $row['grade'] ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required',
            'subject_code' => 'required',
            'score' => 'nullable|numeric|min:0|max:100',
            'grade' => [
                'nullable',
                Rule::in(['0', '1', '1.5', '2', '2.5', '3', '3.5', '4', 0, 1, 1.5, 2, 2.5, 3, 3.5, 4]),
            ],
        ];
    }
}
