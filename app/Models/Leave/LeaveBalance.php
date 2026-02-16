<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $connection = 'leave_db';
    protected $table = 'leave_balances';

    protected $fillable = [
        'user_id',
        'leave_type_id',
        'year',
        'total_days',
        'used_days',
        'remaining_days',
    ];

    public function user()
    {
        return $this->belongsTo(LeaveUser::class, 'user_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
}
