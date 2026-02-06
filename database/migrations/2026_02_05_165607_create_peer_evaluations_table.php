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
        Schema::create('peer_evaluations', function (Blueprint $row) {
            $row->id();
            $row->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Evaluator
            $row->foreignId('target_student_id')->constrained('students')->onDelete('cascade'); // Evaluatee
            $row->foreignId('subject_id')->constrained()->onDelete('cascade');
            $row->string('semester');
            $row->integer('rating_contribution')->default(0);
            $row->integer('rating_responsibility')->default(0);
            $row->integer('rating_teamwork')->default(0);
            $row->integer('rating_interpersonal')->default(0);
            $row->text('comment')->nullable();
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peer_evaluations');
    }
};
