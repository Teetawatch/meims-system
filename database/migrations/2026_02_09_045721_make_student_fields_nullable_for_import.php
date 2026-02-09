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
        Schema::table('students', function (Blueprint $table) {
            // Drop unique constraints that block import
            $table->dropUnique(['id_card_number']);
            $table->dropUnique(['email']);

            // Make fields nullable so students can fill them in later
            $table->string('batch')->nullable()->change();
            $table->string('fiscal_year')->nullable()->change();
            $table->string('id_card_number')->nullable()->change();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->change();
            $table->string('title_th')->nullable()->change();
            $table->date('birth_date')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('batch')->nullable(false)->change();
            $table->string('fiscal_year')->nullable(false)->change();
            $table->string('id_card_number')->nullable(false)->change();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable(false)->change();
            $table->string('title_th')->nullable(false)->change();
            $table->date('birth_date')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();

            $table->unique('id_card_number');
            $table->unique('email');
        });
    }
};
