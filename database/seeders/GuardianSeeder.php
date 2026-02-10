<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuardianSeeder extends Seeder
{
    public function run()
    {
        // Try to find an existing student to attach to
        $student = Student::first();

        // If no student exists, create a dummy one (though unlikely given context)
        if (!$student) {
            $student = Student::create([
                'username' => 'S12345',
                'password' => Hash::make('password'),
                'student_id' => '6612345678',
                'first_name_th' => 'ทดสอบ',
                'last_name_th' => 'นักเรียน',
                'title_th' => 'นาย',
                'birth_date' => '2005-01-01',
                'email' => 'student@test.com',
                'current_address' => 'Test Address',
                'subdistrict' => 'Test',
                'district' => 'Test',
                'province' => 'Test',
                'zip_code' => '12345',
                // Add other required fields with dummy data or let default handle if nullable
                // Based on migration, many fields were made nullable recently, so this might be enough
            ]);
        }

        // Create a test guardian
        $guardian = Guardian::create([
            'username' => 'parent01',
            'password' => Hash::make('password'), // Simple password for testing
            'title_th' => 'นาย',
            'first_name_th' => 'สมชาย',
            'last_name_th' => 'ผู้ปกครอง',
            'phone' => '0812345678',
            'email' => 'parent@test.com',
            'relationship' => 'บิดา',
            'is_active' => true,
        ]);

        // Link guardian to student
        $guardian->students()->attach($student->id);

        $this->command->info('Guardian created successfully.');
        $this->command->info('Username: parent01');
        $this->command->info('Password: password');
        $this->command->info('Linked to Student: ' . $student->first_name_th . ' ' . $student->last_name_th . ' (' . $student->student_id . ')');
    }
}
