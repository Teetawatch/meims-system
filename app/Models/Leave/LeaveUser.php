<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveUser extends Model
{
    protected $connection = 'leave_db';
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'position',
        'rank',
        'start_date',
        'supervisor_id',
        'deputy_id',
        'manager_id',
        'avatar',
        'signature',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function supervisor()
    {
        return $this->belongsTo(LeaveUser::class, 'supervisor_id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'user_id');
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class, 'user_id');
    }
}
