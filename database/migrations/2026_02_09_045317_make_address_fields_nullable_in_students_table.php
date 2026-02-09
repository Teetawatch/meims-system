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
            $table->text('current_address')->nullable()->change();
            $table->string('subdistrict')->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->string('province')->nullable()->change();
            $table->string('zip_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->text('current_address')->nullable(false)->change();
            $table->string('subdistrict')->nullable(false)->change();
            $table->string('district')->nullable(false)->change();
            $table->string('province')->nullable(false)->change();
            $table->string('zip_code')->nullable(false)->change();
        });
    }
};
