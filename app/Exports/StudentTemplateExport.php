<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentTemplateExport implements WithHeadings, ShouldAutoSize, FromArray, WithStyles
{
    public function headings(): array
    {
        return [
            'student_id',
            'first_name_th',
            'last_name_th',
            'batch',
            'course_name',
            'username',
            'password',
        ];
    }

    public function array(): array
    {
        return [
            [
                '66001',           // student_id
                'สมชาย',           // first_name_th
                'ใจดี',             // last_name_th
                '66',              // batch
                'ช่างอากาศยาน',  // course_name
                'user66001',       // username
                'pass1234',        // password
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
