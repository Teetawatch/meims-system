<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'subject_id',
        'semester',
        'rating_knowledge',
        'rating_method',
        'rating_content_order',
        'rating_motivation',
        'rating_qa',
        'rating_media',
        'rating_documents',
        'comment',
        'problems_suggestions',
    ];
}
