<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teacher_evaluations', function (Blueprint $table) {
            // New criteria replacing old ones
            $table->integer('rating_content_order')->default(0)->after('rating_method'); // ข้อ 3
            $table->integer('rating_motivation')->default(0)->after('rating_content_order'); // ข้อ 4
            $table->integer('rating_qa')->default(0)->after('rating_motivation'); // ข้อ 5
            $table->integer('rating_media')->default(0)->after('rating_qa');     // ข้อ 6
            $table->integer('rating_documents')->default(0)->after('rating_media'); // ข้อ 7

            // Part 2: Problems & Suggestions
            $table->text('problems_suggestions')->nullable()->after('comment');
        });
    }

    public function down(): void
    {
        Schema::table('teacher_evaluations', function (Blueprint $table) {
            $table->dropColumn([
                'rating_content_order',
                'rating_motivation',
                'rating_qa',
                'rating_media',
                'rating_documents',
                'problems_suggestions',
            ]);
        });
    }
};
