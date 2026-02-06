<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function topic()
    {
        return $this->belongsTo(SurveyTopic::class, 'survey_topic_id');
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class);
    }
}
