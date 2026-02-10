<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TeachersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Teacher([
            'teacher_code' => $row['teacher_code'],
            'title_th' => $row['title_th'],
            'first_name_th' => $row['first_name_th'],
            'last_name_th' => $row['last_name_th'],
            'title_en' => $row['title_en'] ?? null,
            'first_name_en' => $row['first_name_en'] ?? null,
            'last_name_en' => $row['last_name_en'] ?? null,
            'position' => $row['position'] ?? null,
            'email' => $row['email'] ?? null,
            'phone' => $row['phone'] ?? null,
            'is_active' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'teacher_code' => 'required|string|unique:teachers,teacher_code',
            'first_name_th' => 'required|string',
            'last_name_th' => 'required|string',
            'email' => 'nullable|email|unique:teachers,email',
        ];
    }
}
