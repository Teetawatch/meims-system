<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeacherTemplateExport implements WithHeadings, ShouldAutoSize, FromArray, WithStyles
{
    public function headings(): array
    {
        return [
            'teacher_code',
            'title_th',
            'first_name_th',
            'last_name_th',
            'position',
            'email',
            'phone',
        ];
    }

    public function array(): array
    {
        return [
            [
                'T001',           // teacher_code
                'อาจารย์',         // title_th
                'สมพงษ์',         // first_name_th
                'เรียนดี',         // last_name_th
                'ครูชำนาญการ',     // position
                'sompong@email.com', // email
                '0812345678',      // phone
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
