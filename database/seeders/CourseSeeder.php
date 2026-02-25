<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'course_code' => 'ARC001',
                'course_name_th' => 'สถาปัตยกรรมศาสตร์ (ตัวอย่าง)',
                'course_name_en' => 'Architecture',
                'description' => 'หลักสูตรการออกแบบสถาปัตยกรรม',
                'duration' => '5 ปี',
                'is_active' => true,
            ],
            [
                'course_code' => 'IT001',
                'course_name_th' => 'เทคโนโลยีสารสนเทศ (ตัวอย่าง)',
                'course_name_en' => 'Information Technology',
                'description' => 'หลักสูตรการพัฒนาซอฟต์แวร์และระบบเครือข่าย',
                'duration' => '4 ปี',
                'is_active' => true,
            ],
            [
                'course_code' => 'GRA001',
                'course_name_th' => 'กราฟิกดีไซน์ (ตัวอย่าง)',
                'course_name_en' => 'Graphic Design',
                'description' => 'หลักสูตรการออกแบบสื่อประสมและกราฟิก',
                'duration' => '4 ปี',
                'is_active' => true,
            ],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(['course_code' => $course['course_code']], $course);
        }
    }
}
