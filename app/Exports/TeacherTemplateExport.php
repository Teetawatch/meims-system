<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'teacher_code',
            'title_th',
            'first_name_th',
            'last_name_th',
            'title_en',
            'first_name_en',
            'last_name_en',
            'position',
            'email',
            'phone',
        ];
    }
}
