<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'birth_date' => 'date',
        'enrollment_date' => 'date',
        'gpa_y1_t1' => 'float',
        'weight' => 'float',
        'height' => 'float',
        'father_age' => 'integer',
        'father_income' => 'float',
        'mother_age' => 'integer',
        'mother_income' => 'float',
        'total_family_income' => 'float',
        'family_members_count' => 'integer',
    ];

    public function course()
    {
        // Many students can have the same course name. 
        // In the migration it was a string 'course_name'. 
        // We should ideally relate it to Course model if possible, 
        // but for now let's use the string or add course_id.
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function conductScores()
    {
        return $this->hasMany(ConductScore::class);
    }

    public function getTotalConductScoreAttribute()
    {
        return 100 + $this->conductScores()->sum('score');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function peerEvaluationsAsTarget()
    {
        return $this->hasMany(PeerEvaluation::class, 'target_student_id');
    }
}
