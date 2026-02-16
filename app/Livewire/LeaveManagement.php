<?php

namespace App\Livewire;

use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveRequest;
use App\Models\Leave\LeaveType;
use App\Models\Leave\LeaveUser;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveManagement extends Component
{
    use WithPagination;

    // Tab state
    public $activeTab = 'history'; // 'history' or 'create'

    // Search / Filter
    public $search = '';
    public $statusFilter = '';
    public $leaveTypeFilter = '';

    // Create Leave Request form
    public $selectedUserId = '';
    public $leaveTypeId = '';
    public $startDate = '';
    public $endDate = '';
    public $reason = '';
    public $contactAddress = '';
    public $temporaryLeavePeriod = '';

    // Data
    public $leaveUsers = [];
    public $leaveTypes = [];
    public $selectedUserBalances = [];

    // Detail modal
    public $showDetailModal = false;
    public $detailRequest = null;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'selectedUserId' => 'required',
        'leaveTypeId' => 'required',
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
        'reason' => 'required|string|max:500',
    ];

    protected $messages = [
        'selectedUserId.required' => 'กรุณาเลือกผู้ขอลา',
        'leaveTypeId.required' => 'กรุณาเลือกประเภทการลา',
        'startDate.required' => 'กรุณาเลือกวันที่เริ่มต้น',
        'endDate.required' => 'กรุณาเลือกวันที่สิ้นสุด',
        'endDate.after_or_equal' => 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น',
        'reason.required' => 'กรุณาระบุเหตุผล',
        'reason.max' => 'เหตุผลต้องไม่เกิน 500 ตัวอักษร',
    ];

    public function mount()
    {
        $this->loadLeaveUsers();
        $this->loadLeaveTypes();
    }

    public function loadLeaveUsers()
    {
        $this->leaveUsers = LeaveUser::orderBy('name')->get();
    }

    public function loadLeaveTypes()
    {
        $this->leaveTypes = LeaveType::all();
    }

    public function updatedSelectedUserId($value)
    {
        if ($value) {
            $this->loadUserBalances($value);
        } else {
            $this->selectedUserBalances = [];
        }
    }

    public function loadUserBalances($userId)
    {
        $currentYear = now()->year;
        $balances = LeaveBalance::with('leaveType')
            ->where('user_id', $userId)
            ->where('year', $currentYear)
            ->get();

        $this->selectedUserBalances = $balances->toArray();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        if ($tab === 'create') {
            $this->resetCreateForm();
        }
    }

    public function resetCreateForm()
    {
        $this->selectedUserId = '';
        $this->leaveTypeId = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->reason = '';
        $this->contactAddress = '';
        $this->temporaryLeavePeriod = '';
        $this->selectedUserBalances = [];
        $this->resetErrorBag();
    }

    public function createLeaveRequest()
    {
        $this->validate();

        $user = LeaveUser::findOrFail($this->selectedUserId);
        $leaveType = LeaveType::findOrFail($this->leaveTypeId);

        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);
        $diffDays = $startDate->diffInDays($endDate) + 1;

        // Check advance notice
        if ($leaveType->requires_advance_notice && $leaveType->slug !== 'personal') {
            $daysInAdvance = now()->diffInDays($startDate, false);
            if ($daysInAdvance < $leaveType->advance_notice_days) {
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'ไม่สามารถส่งใบลาได้',
                    'text' => "ประเภทการลานี้ต้องยื่นล่วงหน้าอย่างน้อย {$leaveType->advance_notice_days} วัน",
                ]);
                return;
            }
        }

        // Check retroactive
        if (!$leaveType->allows_retroactive) {
            if ($startDate->isPast() && !$startDate->isToday()) {
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'ไม่สามารถส่งใบลาได้',
                    'text' => 'ประเภทการลานี้ไม่สามารถยื่นย้อนหลังได้',
                ]);
                return;
            }
        }

        // Check balance
        $currentYear = now()->year;
        $balance = LeaveBalance::firstOrCreate(
            ['user_id' => $user->id, 'leave_type_id' => $leaveType->id, 'year' => $currentYear],
            [
                'total_days' => $leaveType->max_days_per_year,
                'used_days' => 0,
                'remaining_days' => $leaveType->max_days_per_year,
            ]
        );

        if ($balance->remaining_days < $diffDays) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'วันลาไม่เพียงพอ',
                'text' => "วันลาคงเหลือ {$balance->remaining_days} วัน แต่ต้องการ {$diffDays} วัน",
            ]);
            return;
        }

        // Create leave request
        LeaveRequest::create([
            'user_id' => $user->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $diffDays,
            'reason' => $this->reason,
            'contact_address' => $this->contactAddress ? ['address' => $this->contactAddress] : null,
            'temporary_leave_period' => $this->temporaryLeavePeriod ?: null,
            'status' => 'pending_supervisor',
        ]);

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ส่งใบลาสำเร็จ!',
            'text' => "{$user->name} ขอ{$leaveType->name} จำนวน {$diffDays} วัน",
        ]);

        $this->resetCreateForm();
        $this->activeTab = 'history';
    }

    public function showDetail($requestId)
    {
        $this->detailRequest = LeaveRequest::with(['user', 'leaveType', 'approvals.approver'])
            ->find($requestId);
        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->detailRequest = null;
    }

    public function cancelRequest($requestId)
    {
        $request = LeaveRequest::findOrFail($requestId);

        if (!in_array($request->status, ['pending_supervisor', 'pending_head', 'pending_manager'])) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'ไม่สามารถยกเลิกได้',
                'text' => 'ไม่สามารถยกเลิกคำขอที่ดำเนินการเสร็จสิ้นแล้วได้',
            ]);
            return;
        }

        $request->status = 'cancelled';
        $request->cancelled_at = now();
        $request->save();

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'ยกเลิกสำเร็จ',
            'text' => 'ยกเลิกคำขอลาเรียบร้อยแล้ว',
        ]);

        $this->closeDetail();
    }

    public function render()
    {
        $query = LeaveRequest::with(['user', 'leaveType', 'approvals'])
            ->orderBy('created_at', 'desc');

        // Filters
        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->leaveTypeFilter) {
            $query->where('leave_type_id', $this->leaveTypeFilter);
        }

        $leaveRequests = $query->paginate(15);

        // Statistics
        $currentYear = now()->year;
        $stats = [
            'total_requests' => LeaveRequest::whereYear('created_at', $currentYear)->count(),
            'pending' => LeaveRequest::whereIn('status', ['pending_supervisor', 'pending_head', 'pending_manager'])->count(),
            'approved' => LeaveRequest::where('status', 'approved')->whereYear('created_at', $currentYear)->count(),
            'rejected' => LeaveRequest::where('status', 'rejected')->whereYear('created_at', $currentYear)->count(),
        ];

        return view('livewire.leave-management', [
            'leaveRequests' => $leaveRequests,
            'stats' => $stats,
        ])->layout('components.layouts.app');
    }
}
