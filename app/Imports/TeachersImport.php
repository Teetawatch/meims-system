<?php

namespace App\Imports;

use App\Models\Teacher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip if teacher_code is missing
            if (!isset($row['teacher_code']) || empty($row['teacher_code'])) {
                continue;
            }

            Teacher::updateOrCreate(
                ['teacher_code' => $row['teacher_code']],
                [
                    'title_th'      => $row['title_th'] ?? null,
                    'first_name_th' => $row['first_name_th'] ?? null,
                    'last_name_th'  => $row['last_name_th'] ?? null,
                    'position'      => $row['position'] ?? null,
                    'email'         => $row['email'] ?? null,
                    'phone'         => $row['phone'] ?? null,
                    'is_active'     => true,
                ]
            );
        }
    }
}
