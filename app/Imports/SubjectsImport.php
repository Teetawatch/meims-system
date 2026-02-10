<?php

namespace App\Imports;

use App\Models\Subject;
use App\Models\Course;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubjectsImport implements OnEachRow, WithHeadingRow, WithValidation
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        $course = Course::where('course_code', $row['course_code'])->first();

        if (!$course) {
            return; // Skip if course not found
        }

        $subject = Subject::updateOrCreate(
            ['subject_code' => $row['subject_code']],
            [
                'subject_name_th' => $row['subject_name_th'],
                'subject_name_en' => $row['subject_name_en'] ?? null,
                'credits' => $row['credits'],
                'course_id' => $course->id,
                'is_active' => true,
            ]
        );

        // Handle Teachers (comma separated codes)
        if (!empty($row['teacher_codes'])) {
            $teacherCodes = array_map('trim', explode(',', $row['teacher_codes']));
            $teacherIds = Teacher::whereIn('teacher_code', $teacherCodes)->pluck('id')->toArray();
            $subject->teacher()->sync($teacherIds);
        }
    }

    public function rules(): array
    {
        return [
            'subject_code' => 'required|string',
            'subject_name_th' => 'required|string',
            'credits' => 'required|integer',
            'course_code' => 'required|exists:courses,course_code',
        ];
    }
}
