<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'title_th' => 'นาย',
                'first_name_th' => 'สมชาย',
                'last_name_th' => 'ใจดี',
                'title_en' => 'Mr.',
                'first_name_en' => 'Somchai',
                'last_name_en' => 'Jaidee',
                'student_id' => '66001',
                'gender' => 'Male',
                'batch' => '84',
            ],
            [
                'title_th' => 'นางสาว',
                'first_name_th' => 'กานดา',
                'last_name_th' => 'รักไทย',
                'title_en' => 'Ms.',
                'first_name_en' => 'Kanda',
                'last_name_en' => 'Rakthai',
                'student_id' => '66002',
                'gender' => 'Female',
                'batch' => '84',
            ],
            [
                'title_th' => 'นาย',
                'first_name_th' => 'วีระ',
                'last_name_th' => 'มั่นคง',
                'title_en' => 'Mr.',
                'first_name_en' => 'Weera',
                'last_name_en' => 'Mankong',
                'student_id' => '66003',
                'gender' => 'Male',
                'batch' => '84',
            ],
            [
                'title_th' => 'นางสาว',
                'first_name_th' => 'สุดา',
                'last_name_th' => 'สวยงาม',
                'title_en' => 'Ms.',
                'first_name_en' => 'Suda',
                'last_name_en' => 'Suayngam',
                'student_id' => '66004',
                'gender' => 'Female',
                'batch' => '84',
            ],
            [
                'title_th' => 'นาย',
                'first_name_th' => 'ปิติ',
                'last_name_th' => 'ยินดี',
                'title_en' => 'Mr.',
                'first_name_en' => 'Piti',
                'last_name_en' => 'Yindee',
                'student_id' => '66005',
                'gender' => 'Male',
                'batch' => '84',
            ],
            [
                'title_th' => 'นางสาว',
                'first_name_th' => 'มานี',
                'last_name_th' => 'มีตา',
                'title_en' => 'Ms.',
                'first_name_en' => 'Manee',
                'last_name_en' => 'Meeta',
                'student_id' => '66006',
                'gender' => 'Female',
                'batch' => '84',
            ],
            [
                'title_th' => 'นาย',
                'first_name_th' => 'ชูใจ',
                'last_name_th' => 'เลิศล้ำ',
                'title_en' => 'Mr.',
                'first_name_en' => 'Chujai',
                'last_name_en' => 'Lertlam',
                'student_id' => '66007',
                'gender' => 'Male',
                'batch' => '84',
            ],
            [
                'title_th' => 'นาย',
                'first_name_th' => 'กล้า',
                'last_name_th' => 'เก่งกล้า',
                'title_en' => 'Mr.',
                'first_name_en' => 'Kla',
                'last_name_en' => 'Kengkla',
                'student_id' => '66008',
                'gender' => 'Male',
                'batch' => '84',
            ],
            [
                'title_th' => 'นางสาว',
                'first_name_th' => 'แก้ว',
                'last_name_th' => 'กล้าหาญ',
                'title_en' => 'Ms.',
                'first_name_en' => 'Kaew',
                'last_name_en' => 'Klahan',
                'student_id' => '66009',
                'gender' => 'Female',
                'batch' => '84',
            ],
            [
                'title_th' => 'นาย',
                'first_name_th' => 'จอม',
                'last_name_th' => 'พลัง',
                'title_en' => 'Mr.',
                'first_name_en' => 'Jom',
                'last_name_en' => 'Palang',
                'student_id' => '66010',
                'gender' => 'Male',
                'batch' => '84',
            ],
        ];

        foreach ($students as $index => $student) {
            Student::firstOrCreate(
                ['student_id' => $student['student_id']],
                array_merge($student, [
                    'username' => $student['student_id'],
                    'password' => Hash::make('password'),
                    'email' => $student['student_id'] . '@meims.com', // Mock email
                    'birth_date' => '2000-01-01',
                    'id_card_number' => '12345678901' . str_pad($index, 2, '0', STR_PAD_LEFT), // Unique ID Card
                    'fiscal_year' => '2567',
                    'religion' => 'พุทธ',
                    'race' => 'ไทย',
                    'nationality' => 'ไทย',
                    'birth_province' => 'กรุงเทพฯ',
                    'phone' => '08123456' . str_pad($index, 2, '0', STR_PAD_LEFT), // Unique Phone
                    'current_address' => '99/99 ถ.พหลโยธิน',
                    'subdistrict' => 'ลาดยาว',
                    'district' => 'จตุจักร',
                    'province' => 'กรุงเทพฯ',
                    'zip_code' => '10900',
                    'housing_status' => 'บ้านส่วนตัว',
                    'residence_type' => 'บ้านเดี่ยว',
                    'father_name' => 'บิดา สมมติ',
                    'father_age' => 50,
                    'father_occupation' => 'รับราชการ',
                    'father_income' => 30000,
                    'mother_name' => 'มารดา สมมติ',
                    'mother_age' => 48,
                    'mother_occupation' => 'แม่บ้าน',
                    'mother_income' => 0,
                    'parents_marital_status' => 'อยู่ด้วยกัน',
                    'total_family_income' => 30000,
                    'family_members_count' => 4,
                    'enrollment_date' => '2024-05-16',
                    'degree_level' => 'ปริญญาตรี',
                    'course_name' => 'นักเรียนพลาธิการ',
                    'gpa_y1_t1' => 3.50,
                    'weight' => 65,
                    'height' => 170,
                ])
            );
        }
    }
}
