<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $connection = 'leave_db';
    protected $table = 'leave_requests';

    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'contact_address',
        'temporary_leave_period',
        'status',
        'attachment_path',
        'cancelled_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cancelled_at' => 'datetime',
        'contact_address' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(LeaveUser::class, 'user_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function approvals()
    {
        return $this->hasMany(LeaveApproval::class, 'leave_request_id');
    }

    /**
     * Get status label in Thai
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_supervisor' => 'รอผู้บังคับบัญชาอนุมัติ',
            'pending_head' => 'รอหัวหน้าแผนกอนุมัติ',
            'pending_manager' => 'รอผู้จัดการอนุมัติ',
            'approved' => 'อนุมัติแล้ว',
            'rejected' => 'ไม่อนุมัติ',
            'cancelled' => 'ยกเลิกแล้ว',
            default => $this->status,
        };
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending_supervisor', 'pending_head', 'pending_manager' => 'amber',
            'approved' => 'emerald',
            'rejected' => 'red',
            'cancelled' => 'slate',
            default => 'blue',
        };
    }
}
