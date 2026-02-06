<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyTopic extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function getAverageScoreAttribute()
    {
        // Calculate average from all related answers
        // Optimization: This could be heavy with large datasets. 
        // Better approach: Calculate average per question and then average of averages, or join tables.
        // Simple approach for now:

        $totalScore = 0;
        $count = 0;

        foreach ($this->responses as $response) {
            $answers = $response->answers;
            if ($answers->count() > 0) {
                $totalScore += $answers->avg('score');
                $count++;
            }
        }

        return $count > 0 ? $totalScore / $count : 0;
    }

    public function getTotalResponsesAttribute()
    {
        return $this->responses()->count();
    }
}
