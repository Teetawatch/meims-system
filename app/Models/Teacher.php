<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function evaluations()
    {
        return $this->hasMany(TeacherEvaluation::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->evaluations()->avg('rating_overall') ?: 0;
    }
}
