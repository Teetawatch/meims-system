<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentReportExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Student::query();

        if (!empty($this->filters['fiscal_year'])) {
            $query->where('fiscal_year', $this->filters['fiscal_year']);
        }

        if (!empty($this->filters['batch'])) {
            $query->where('batch', $this->filters['batch']);
        }

        if (!empty($this->filters['course_name'])) {
            $query->where('course_name', $this->filters['course_name']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'รหัสนักเรียน',
            'ชื่อ-นามสกุล (TH)',
            'Name (EN)',
            'หลักสูตร',
            'รุ่น',
            'ปีงบประมาณ',
            'เบอร์โทรศัพท์',
            'อีเมล',
            'สถานะ',
        ];
    }

    public function map($student): array
    {
        return [
            $student->student_id,
            $student->title_th . $student->first_name_th . ' ' . $student->last_name_th,
            $student->title_en . $student->first_name_en . ' ' . $student->last_name_en,
            $student->course_name,
            $student->batch,
            $student->fiscal_year,
            $student->phone,
            $student->email,
            'ปกติ', // Assuming status is static for now or add status field later
        ];
    }
}
