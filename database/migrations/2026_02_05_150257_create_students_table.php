<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Account Info
            $table->string('username')->unique();
            $table->string('password');
            $table->string('photo_path')->nullable();

            // General Info
            $table->string('student_id')->unique(); // รหัสนักเรียน
            $table->string('batch'); // รุ่น
            $table->string('fiscal_year'); // ปีงบประมาณ
            $table->string('id_card_number')->unique(); // เลขประจำตัวประชาชน
            $table->enum('gender', ['Male', 'Female', 'Other']); // เพศ

            // Name Info
            $table->string('title_th');
            $table->string('first_name_th');
            $table->string('last_name_th');
            $table->string('title_en')->nullable();
            $table->string('first_name_en')->nullable();
            $table->string('last_name_en')->nullable();

            // Personal Personal
            $table->date('birth_date');
            $table->string('blood_type')->nullable();
            $table->string('religion')->nullable();
            $table->string('race')->nullable();
            $table->string('nationality')->nullable();
            $table->string('birth_province')->nullable();

            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->unique();

            // Address
            $table->text('current_address');
            $table->string('subdistrict');
            $table->string('district');
            $table->string('province');
            $table->string('zip_code');
            $table->string('housing_status')->nullable(); // สถานะบ้าน
            $table->string('residence_type')->nullable(); // ที่พักอาศัย

            // Father
            $table->string('father_name')->nullable();
            $table->integer('father_age')->nullable();
            $table->string('father_occupation')->nullable();
            $table->decimal('father_income', 10, 2)->nullable();

            // Mother
            $table->string('mother_name')->nullable();
            $table->integer('mother_age')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->decimal('mother_income', 10, 2)->nullable();

            // Family
            $table->string('parents_marital_status')->nullable();
            $table->decimal('total_family_income', 10, 2)->nullable();
            $table->integer('family_members_count')->nullable();
            $table->text('siblings_info')->nullable(); // JSON or Text

            // Education
            $table->date('enrollment_date')->nullable();
            $table->string('degree_level')->nullable();
            $table->string('course_name')->nullable();
            $table->decimal('gpa_y1_t1', 3, 2)->nullable();
            $table->decimal('gpa_y1_t2', 3, 2)->nullable();

            // Health
            $table->decimal('weight', 5, 2)->nullable(); // kg
            $table->decimal('height', 5, 2)->nullable(); // cm
            $table->text('disabilities')->nullable();
            $table->text('chronic_diseases')->nullable();
            $table->text('allergies')->nullable();
            $table->text('mental_health_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
