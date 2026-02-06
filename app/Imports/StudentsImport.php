<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return Student::firstOrCreate(
            ['student_id' => $row['student_id']],
            [
                'title_th' => $row['title_th'],
                'first_name_th' => $row['first_name_th'],
                'last_name_th' => $row['last_name_th'],
                'title_en' => $row['title_en'],
                'first_name_en' => $row['first_name_en'],
                'last_name_en' => $row['last_name_en'],
                'batch' => $row['batch'],
                'id_card_number' => $row['id_card_number'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'username' => $row['student_id'],
                'password' => Hash::make('password'), // Default password
                'gender' => 'Not Specified', // Default or add to template
                // Add defaults for required fields to avoid errors if not in Excel
                'birth_date' => '2000-01-01',
                'fiscal_year' => '2567',
            ]
        );
    }
}
