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
        Schema::create('teacher_evaluations', function (Blueprint $row) {
            $row->id();
            $row->foreignId('student_id')->constrained()->onDelete('cascade');
            $row->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $row->foreignId('subject_id')->constrained()->onDelete('cascade');
            $row->string('semester');
            $row->integer('rating_knowledge')->default(0);
            $row->integer('rating_method')->default(0);
            $row->integer('rating_attitude')->default(0);
            $row->integer('rating_timeliness')->default(0);
            $row->integer('rating_support')->default(0);
            $row->text('comment')->nullable();
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_evaluations');
    }
};
