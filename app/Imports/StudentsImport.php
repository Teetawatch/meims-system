<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip if student_id is missing
            if (!isset($row['student_id']) || empty($row['student_id'])) {
                continue;
            }

            Student::updateOrCreate(
                ['student_id' => $row['student_id']],
                [
                'first_name_th'  => $row['first_name_th'] ?? null,
                'last_name_th'   => $row['last_name_th'] ?? null,
                'username'       => $row['student_id'],
                'password'       => Hash::make($row['student_id']),
            ]);
        }
    }
}
