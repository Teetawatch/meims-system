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
        Schema::create('teachers', function (Blueprint $row) {
            $row->id();
            $row->string('teacher_code')->unique();
            $row->string('title_th')->nullable();
            $row->string('first_name_th');
            $row->string('last_name_th');
            $row->string('title_en')->nullable();
            $row->string('first_name_en')->nullable();
            $row->string('last_name_en')->nullable();
            $row->string('position')->nullable();
            $row->string('email')->nullable();
            $row->string('phone')->nullable();
            $row->boolean('is_active')->default(true);
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
