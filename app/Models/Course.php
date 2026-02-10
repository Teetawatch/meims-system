<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function surveyTopics()
    {
        return $this->belongsToMany(SurveyTopic::class, 'course_survey_topic');
    }
}
