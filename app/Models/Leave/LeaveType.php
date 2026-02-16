<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $connection = 'leave_db';
    protected $table = 'leave_types';

    protected $fillable = [
        'name',
        'slug',
        'max_days_per_year',
        'requires_advance_notice',
        'advance_notice_days',
        'allows_retroactive',
        'requires_file',
    ];
}
