<?php

namespace App\Imports;

use App\Models\Subject;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubjectsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $course = Course::where('course_code', $row['course_code'])->first();

        if (!$course) {
            return null; // Skip if course not found
        }

        return new Subject([
            'subject_code' => $row['subject_code'],
            'subject_name_th' => $row['subject_name_th'],
            'subject_name_en' => $row['subject_name_en'] ?? null,
            'credits' => $row['credits'],
            'course_id' => $course->id,
            'is_active' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'subject_code' => 'required|string|unique:subjects,subject_code',
            'subject_name_th' => 'required|string',
            'credits' => 'required|integer',
            'course_code' => 'required|exists:courses,course_code',
        ];
    }
}
