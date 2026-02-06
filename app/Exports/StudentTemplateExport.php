<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentTemplateExport implements WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'student_id',
            'title_th',
            'first_name_th',
            'last_name_th',
            'title_en',
            'first_name_en',
            'last_name_en',
            'batch',
            'id_card_number',
            'phone',
            'email'
        ];
    }
}
