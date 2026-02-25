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
            $table->string('rank')->nullable()->after('gender');
            $table->string('position')->nullable()->after('rank');
            $table->string('affiliation')->nullable()->after('position');
            $table->date('enlistment_date')->nullable()->after('birth_date');
            $table->string('service_age')->nullable()->after('enlistment_date');
            $table->string('marital_status')->nullable()->after('service_age');
            $table->string('spouse_name')->nullable()->after('marital_status');
            $table->json('children_info')->nullable()->after('spouse_name');
            $table->string('education_before_service')->nullable()->after('degree_level');
            $table->json('military_education')->nullable()->after('education_before_service');
            $table->string('workplace')->nullable()->after('zip_code');
            $table->string('workplace_phone')->nullable()->after('workplace');
            $table->json('past_positions')->nullable()->after('workplace_phone');
            $table->text('special_skills')->nullable()->after('past_positions');
            $table->text('motto')->nullable()->after('special_skills');
            $table->string('academic_year')->nullable()->after('fiscal_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
