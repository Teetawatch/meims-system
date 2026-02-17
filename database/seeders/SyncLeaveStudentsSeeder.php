<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Carbon\Carbon;

class SyncLeaveStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Target Departments (หลักสูตรที่ต้องการดึง)
        $targetDepartments = [
            'หลักสูตรนายทหารพลาธิการชั้นนายเรือ ประจำปีงบประมาณ 69',
            'หลักสูตรอาชีพเพื่อเลื่อนฐานะชั้น จ.อ.'
        ];

        // 2. Fetch Users from Leave System DB
        $leaveUsers = DB::connection('leave_db')
            ->table('users')
            ->whereIn('department', $targetDepartments)
            ->get();

        $this->command->info("Found " . $leaveUsers->count() . " students in Leave System.");

        foreach ($leaveUsers as $lUser) {
            // 3. Create or Update Student in MEIMS
            // Split Name (Assumption: First Last)
            $parts = explode(' ', $lUser->name, 2);
            $firstName = $parts[0];
            $lastName = $parts[1] ?? '-';

            // Generate Dummy ID Card (Unique)
            // Format: 9 + 000 + leave_id + random (13 digits)
            $dummyIdCard = '9' . str_pad($lUser->id, 4, '0', STR_PAD_LEFT) . mt_rand(10000000, 99999999);
            $dummyIdCard = substr($dummyIdCard, 0, 13);

            // Handle Null Email/Username
            $cleanEmail = trim($lUser->email ?? '');
            if ($cleanEmail === '') {
                $username = 'student.LS' . str_pad($lUser->id, 5, '0', STR_PAD_LEFT);
            } else {
                $username = $cleanEmail;
            }

            Student::updateOrCreate(
                ['leave_user_id' => $lUser->id], // Changed logic: Check by leave_user_id (more robust) or email if exists
                [
                    'email' => $lUser->email, // Can be null (if allowed by DB, otherwise default needed)
                    'username' => $username,  // Must not be null

                    'password' => bcrypt('password'), // Dummy password
                    'leave_user_id' => $lUser->id,
                    
                    // Name
                    'title_th' => $lUser->rank ?? 'นาย/นางสาว', // Use Rank as Title
                    'title_en' => 'Mr/Ms', // Leave DB doesn't have EN rank?
                    'first_name_th' => $firstName,
                    'last_name_th' => $lastName,
                    
                    // IDs
                    'student_id' => 'LS' . str_pad($lUser->id, 5, '0', STR_PAD_LEFT),
                    'id_card_number' => $dummyIdCard, // Dummy Unique ID Card
            // Map Department to Course & Batch
            $department = $lUser->department;
            $courseName = $department;
            $batch = '69'; // Default

            if (str_contains($department, 'ชั้นนายเรือ')) {
                $courseName = 'หลักสูตรนายทหารพลาธิการชั้นนายเรือ';
                // Extract batch from string if needed, e.g. "ประจำปีงบประมาณ 69" -> "69"
                if (preg_match('/(\d+)/', $department, $matches)) {
                   $batch = $matches[1];
                }
            } elseif (str_contains($department, 'เลื่อนฐานะ')) {
                $courseName = 'หลักสูตรอาชีพเพื่อเลื่อนฐานะชั้น จ.อ.';
                $batch = 'N/A'; // Or specific batch for this course
            }

            // Map Department to Course & Batch
            $department = $lUser->department;
            $courseName = $department;
            $batch = '69'; // Default

            if (str_contains($department, 'ชั้นนายเรือ')) {
                $courseName = 'หลักสูตรนายทหารพลาธิการชั้นนายเรือ';
                if (preg_match('/(\d+)/', $department, $matches)) {
                   $batch = $matches[1];
                }
            } elseif (str_contains($department, 'เลื่อนฐานะ')) {
                $courseName = 'หลักสูตรอาชีพเพื่อเลื่อนฐานะชั้น จ.อ.';
                $batch = 'N/A';
            }

            Student::updateOrCreate(
                ['leave_user_id' => $lUser->id], 
                [   
                    'email' => $lUser->email,
                    'username' => $username,
                    'password' => bcrypt('password'),
                    'leave_user_id' => $lUser->id,
                    
                    // Name
                    'title_th' => $lUser->rank ?? 'นาย/นางสาว',
                    'title_en' => 'Mr/Ms',
                    'first_name_th' => $firstName,
                    'last_name_th' => $lastName,
                    
                    // IDs
                    'student_id' => 'LS' . str_pad($lUser->id, 5, '0', STR_PAD_LEFT),
                    'id_card_number' => $dummyIdCard,
                    
                    // Course Info
                    'course_name' => $courseName,
                    'batch' => $batch, 
                    'fiscal_year' => '2569',
                    
                    'gender' => 'Male',

                    // Contact & Address
                    'phone' => '000-000-0000',
                    'current_address' => '-',
                    'subdistrict' => '-',
                    'district' => '-',
                    'province' => '-',
                    'zip_code' => '00000',

                    // Personal
                    'birth_date' => Carbon::parse('2000-01-01'),
                    'enrollment_date' => Carbon::now(),
                    
                    // Stats
                    'weight' => 0,
                    'height' => 0,
                    'gpa_y1_t1' => 0.00,
                    'total_family_income' => 0,
                    'family_members_count' => 0,
                    'father_age' => 0,
                    'mother_age' => 0,
                ]
            );
        }

        $this->command->info("Sync Completed! All students imported/updated.");
    }
}
