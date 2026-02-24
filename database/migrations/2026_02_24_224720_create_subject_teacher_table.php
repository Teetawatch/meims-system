<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Allow multiple same teachers? No, usually unique.
            $table->unique(['subject_id', 'teacher_id']);
        });

        // Migrate existing teacher_id from subjects to subject_teacher
        $subjects = \Illuminate\Support\Facades\DB::table('subjects')->whereNotNull('teacher_id')->get();
        foreach ($subjects as $subject) {
            \Illuminate\Support\Facades\DB::table('subject_teacher')->insert([
                'subject_id' => $subject->id,
                'teacher_id' => $subject->teacher_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_teacher');
    }
};
