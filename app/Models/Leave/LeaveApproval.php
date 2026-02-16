<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveApproval extends Model
{
    protected $connection = 'leave_db';
    protected $table = 'leave_approvals';

    protected $fillable = [
        'leave_request_id',
        'approver_id',
        'step',
        'action',
        'comment',
        'signature',
        'ip_address',
    ];

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class, 'leave_request_id');
    }

    public function approver()
    {
        return $this->belongsTo(LeaveUser::class, 'approver_id');
    }
}
