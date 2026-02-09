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
            'title_th',       // Required
            'first_name_th',  // Required
            'last_name_th',   // Required
            'title_en',
            'first_name_en',
            'last_name_en',
            'batch',
            'id_card_number',
            'phone',
            'email'
        ];
    }

    public function array(): array
    {
        return [
            [
                '66001',           // student_id
                'นาย',             // title_th
                'สมชาย',           // first_name_th
                'ใจดี',             // last_name_th
                'Mr.',             // title_en
                'Somchai',         // first_name_en
                'Jaidee',          // last_name_en
                '66',              // batch
                '1234567890123',   // id_card_number
                '0812345678',      // phone
                'student@example.com' // email
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
