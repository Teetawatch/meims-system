<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20">
    <!-- Sidebar -->
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/30 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false">
        </div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200/60 shadow-lg transform transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            @include('components.sidebar')
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <!-- Top Bar -->
            <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                ระบบการลา
                            </h1>
                            <p class="text-sm text-slate-500 mt-0.5">จัดการใบลาและดูประวัติการลา</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                            <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            ปี {{ now()->year + 543 }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="px-6 lg:px-8 py-6 space-y-6">

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Requests -->
                    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-50 rounded-bl-[40px] opacity-60 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_requests']) }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">คำขอทั้งหมด</p>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-100 to-amber-50 rounded-bl-[40px] opacity-60 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['pending']) }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">รออนุมัติ</p>
                        </div>
                    </div>

                    <!-- Approved -->
                    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-bl-[40px] opacity-60 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['approved']) }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">อนุมัติแล้ว</p>
                        </div>
                    </div>

                    <!-- Rejected -->
                    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-red-100 to-red-50 rounded-bl-[40px] opacity-60 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['rejected']) }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">ไม่อนุมัติ</p>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-200/60">
                        <div class="flex">
                            <button wire:click="switchTab('history')"
                                class="flex-1 sm:flex-none px-6 py-4 text-sm font-semibold transition-all relative {{ $activeTab === 'history' ? 'text-blue-600' : 'text-slate-500 hover:text-slate-700' }}">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>ประวัติการลา</span>
                                </div>
                                @if($activeTab === 'history')
                                    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                                @endif
                            </button>
                            <button wire:click="switchTab('create')"
                                class="flex-1 sm:flex-none px-6 py-4 text-sm font-semibold transition-all relative {{ $activeTab === 'create' ? 'text-blue-600' : 'text-slate-500 hover:text-slate-700' }}">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span>ส่งใบลาใหม่</span>
                                </div>
                                @if($activeTab === 'create')
                                    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                                @endif
                            </button>
                        </div>
                    </div>

                    <!-- Tab: History -->
                    @if($activeTab === 'history')
                    <div class="p-6 space-y-4">
                        <!-- Filters -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1">
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <input wire:model.live.debounce.300ms="search" type="text"
                                        placeholder="ค้นหาชื่อผู้ขอลา..."
                                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-slate-50/50">
                                </div>
                            </div>
                            <select wire:model.live="statusFilter"
                                class="px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-slate-50/50">
                                <option value="">สถานะทั้งหมด</option>
                                <option value="pending_supervisor">รอผู้บังคับบัญชา</option>
                                <option value="pending_head">รอหัวหน้าแผนก</option>
                                <option value="pending_manager">รอผู้จัดการ</option>
                                <option value="approved">อนุมัติแล้ว</option>
                                <option value="rejected">ไม่อนุมัติ</option>
                                <option value="cancelled">ยกเลิก</option>
                            </select>
                            <select wire:model.live="leaveTypeFilter"
                                class="px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-slate-50/50">
                                <option value="">ประเภทลาทั้งหมด</option>
                                @foreach($leaveTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-slate-50/80">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ผู้ขอลา</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ประเภท</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">วันที่</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">จำนวนวัน</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">สถานะ</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($leaveRequests as $request)
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                                    {{ mb_substr($request->user->name ?? '?', 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-800">{{ $request->user->name ?? 'ไม่ระบุ' }}</p>
                                                    <p class="text-[10px] text-slate-400 font-medium">{{ $request->user->department ?? '' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                {{ $request->leaveType->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <p class="text-sm text-slate-700">{{ $request->start_date?->format('d/m/Y') }}</p>
                                            @if($request->start_date != $request->end_date)
                                                <p class="text-[10px] text-slate-400">ถึง {{ $request->end_date?->format('d/m/Y') }}</p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="text-sm font-bold text-slate-700">{{ $request->total_days }}</span>
                                            <span class="text-[10px] text-slate-400"> วัน</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            @php
                                                $colors = [
                                                    'pending_supervisor' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                    'pending_head' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                    'pending_manager' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                    'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                                    'cancelled' => 'bg-slate-50 text-slate-500 border-slate-200',
                                                ];
                                                $colorClass = $colors[$request->status] ?? 'bg-blue-50 text-blue-700 border-blue-200';
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $colorClass }}">
                                                {{ $request->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <button wire:click="showDetail({{ $request->id }})"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                                title="ดูรายละเอียด">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-medium text-slate-500">ยังไม่มีข้อมูลการลา</p>
                                                <p class="text-xs text-slate-400 mt-1">กดปุ่ม "ส่งใบลาใหม่" เพื่อเริ่มต้น</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $leaveRequests->links() }}
                        </div>
                    </div>
                    @endif

                    <!-- Tab: Create -->
                    @if($activeTab === 'create')
                    <div class="p-6">
                        <form wire:submit="createLeaveRequest" class="space-y-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Left Column: Form -->
                                <div class="space-y-5">
                                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </div>
                                        แบบฟอร์มขอลา
                                    </h3>

                                    <!-- User Selection -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">ผู้ขอลา <span class="text-red-500">*</span></label>
                                        <select wire:model.live="selectedUserId"
                                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all {{ $errors->has('selectedUserId') ? 'border-red-300 ring-2 ring-red-500/20' : '' }}">
                                            <option value="">-- เลือกผู้ขอลา --</option>
                                            @foreach($leaveUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} {{ $user->department ? '('.$user->department.')' : '' }}</option>
                                            @endforeach
                                        </select>
                                        @error('selectedUserId')
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Leave Type -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">ประเภทการลา <span class="text-red-500">*</span></label>
                                        <select wire:model="leaveTypeId"
                                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all {{ $errors->has('leaveTypeId') ? 'border-red-300 ring-2 ring-red-500/20' : '' }}">
                                            <option value="">-- เลือกประเภทการลา --</option>
                                            @foreach($leaveTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('leaveTypeId')
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Date Range -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">วันที่เริ่มต้น <span class="text-red-500">*</span></label>
                                            <input wire:model="startDate" type="date"
                                                class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all {{ $errors->has('startDate') ? 'border-red-300 ring-2 ring-red-500/20' : '' }}">
                                            @error('startDate')
                                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">วันที่สิ้นสุด <span class="text-red-500">*</span></label>
                                            <input wire:model="endDate" type="date"
                                                class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all {{ $errors->has('endDate') ? 'border-red-300 ring-2 ring-red-500/20' : '' }}">
                                            @error('endDate')
                                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Temporary Leave Period -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">ช่วงเวลา (ถ้าลาไม่เต็มวัน)</label>
                                        <select wire:model="temporaryLeavePeriod"
                                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                            <option value="">ลาเต็มวัน</option>
                                            <option value="morning">ช่วงเช้า</option>
                                            <option value="afternoon">ช่วงบ่าย</option>
                                        </select>
                                    </div>

                                    <!-- Reason -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">เหตุผลการลา <span class="text-red-500">*</span></label>
                                        <textarea wire:model="reason" rows="3"
                                            placeholder="กรุณาระบุเหตุผลในการลา..."
                                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all resize-none {{ $errors->has('reason') ? 'border-red-300 ring-2 ring-red-500/20' : '' }}"></textarea>
                                        @error('reason')
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Contact Address -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">สถานที่ติดต่อระหว่างลา</label>
                                        <input wire:model="contactAddress" type="text"
                                            placeholder="ที่อยู่หรือเบอร์โทรติดต่อ"
                                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="pt-2">
                                        <button type="submit"
                                            class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 active:scale-[0.98]">
                                            <div class="flex items-center justify-center space-x-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                <span>ส่งใบลา</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <!-- Right Column: User Balance Info -->
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800 flex items-center mb-5">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        วันลาคงเหลือ
                                    </h3>

                                    @if($selectedUserId && count($selectedUserBalances) > 0)
                                        <div class="space-y-3">
                                            @foreach($selectedUserBalances as $balance)
                                            <div class="bg-gradient-to-r from-slate-50 to-white border border-slate-200/80 rounded-xl p-4 hover:shadow-sm transition-shadow">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-sm font-semibold text-slate-700">{{ $balance['leave_type']['name'] ?? '-' }}</span>
                                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $balance['remaining_days'] > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                        คงเหลือ {{ $balance['remaining_days'] }} วัน
                                                    </span>
                                                </div>
                                                <div class="w-full bg-slate-200 rounded-full h-2">
                                                    @php
                                                        $percentage = $balance['total_days'] > 0 ? (($balance['total_days'] - $balance['remaining_days']) / $balance['total_days']) * 100 : 0;
                                                    @endphp
                                                    <div class="h-2 rounded-full transition-all {{ $percentage > 80 ? 'bg-gradient-to-r from-red-400 to-red-500' : ($percentage > 50 ? 'bg-gradient-to-r from-amber-400 to-amber-500' : 'bg-gradient-to-r from-emerald-400 to-emerald-500') }}"
                                                        style="width: {{ min($percentage, 100) }}%"></div>
                                                </div>
                                                <div class="flex justify-between mt-1.5">
                                                    <span class="text-[10px] text-slate-400">ใช้ไป {{ $balance['used_days'] }} วัน</span>
                                                    <span class="text-[10px] text-slate-400">ทั้งหมด {{ $balance['total_days'] }} วัน</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @elseif($selectedUserId)
                                        <div class="bg-slate-50 rounded-xl p-8 text-center border border-slate-200/60">
                                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-slate-500">ยังไม่มีข้อมูลวันลาคงเหลือในปีนี้</p>
                                            <p class="text-xs text-slate-400 mt-1">ระบบจะสร้างข้อมูลอัตโนมัติเมื่อส่งใบลาครั้งแรก</p>
                                        </div>
                                    @else
                                        <div class="bg-blue-50/50 rounded-xl p-8 text-center border border-blue-100">
                                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-blue-600 font-medium">กรุณาเลือกผู้ขอลาก่อน</p>
                                            <p class="text-xs text-blue-400 mt-1">เพื่อดูข้อมูลวันลาคงเหลือ</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $detailRequest)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-init="$el.classList.add('animate-fadeIn')">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeDetail"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-slate-200/60">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white/95 backdrop-blur-lg border-b border-slate-200/60 px-6 py-4 rounded-t-2xl flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">รายละเอียดใบลา</h3>
                    <p class="text-xs text-slate-400">คำขอลา #{{ $detailRequest->id }}</p>
                </div>
                <button wire:click="closeDetail" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-blue-500/20">
                        {{ mb_substr($detailRequest->user->name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-lg font-bold text-slate-800">{{ $detailRequest->user->name ?? '-' }}</p>
                        <p class="text-sm text-slate-500">{{ $detailRequest->user->department ?? '' }} • {{ $detailRequest->user->position ?? '' }}</p>
                    </div>
                </div>

                <!-- Leave Info Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">ประเภทการลา</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $detailRequest->leaveType->name ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">สถานะ</p>
                        @php
                            $colors = [
                                'pending_supervisor' => 'text-amber-700',
                                'pending_head' => 'text-orange-700',
                                'pending_manager' => 'text-yellow-700',
                                'approved' => 'text-emerald-700',
                                'rejected' => 'text-red-700',
                                'cancelled' => 'text-slate-500',
                            ];
                        @endphp
                        <p class="text-sm font-semibold {{ $colors[$detailRequest->status] ?? 'text-blue-700' }}">{{ $detailRequest->status_label }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">วันที่ลา</p>
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $detailRequest->start_date?->format('d/m/Y') }}
                            @if($detailRequest->start_date != $detailRequest->end_date)
                                - {{ $detailRequest->end_date?->format('d/m/Y') }}
                            @endif
                        </p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">จำนวนวัน</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $detailRequest->total_days }} วัน</p>
                    </div>
                </div>

                <!-- Reason -->
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">เหตุผล</p>
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $detailRequest->reason ?? '-' }}</p>
                </div>

                <!-- Contact Address -->
                @if($detailRequest->contact_address)
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">สถานที่ติดต่อระหว่างลา</p>
                    <p class="text-sm text-slate-700">
                        @if(is_array($detailRequest->contact_address))
                            {{ $detailRequest->contact_address['address'] ?? json_encode($detailRequest->contact_address) }}
                        @else
                            {{ $detailRequest->contact_address }}
                        @endif
                    </p>
                </div>
                @endif

                <!-- Approval History -->
                @if($detailRequest->approvals && $detailRequest->approvals->count() > 0)
                <div>
                    <p class="text-sm font-bold text-slate-700 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        ประวัติการอนุมัติ
                    </p>
                    <div class="space-y-2">
                        @foreach($detailRequest->approvals as $approval)
                        <div class="flex items-start space-x-3 bg-white border border-slate-200/60 rounded-xl p-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $approval->action === 'approved' ? 'bg-emerald-100' : 'bg-red-100' }}">
                                @if($approval->action === 'approved')
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-700">{{ $approval->approver->name ?? '-' }}</p>
                                <p class="text-xs text-slate-400">{{ $approval->step }} • {{ $approval->created_at?->format('d/m/Y H:i') }}</p>
                                @if($approval->comment)
                                    <p class="text-xs text-slate-500 mt-1">{{ $approval->comment }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="sticky bottom-0 bg-white/95 backdrop-blur-lg border-t border-slate-200/60 px-6 py-4 rounded-b-2xl flex justify-between">
                @if(in_array($detailRequest->status, ['pending_supervisor', 'pending_head', 'pending_manager']))
                    <button wire:click="cancelRequest({{ $detailRequest->id }})"
                        wire:confirm="คุณต้องการยกเลิกใบลานี้หรือไม่?"
                        class="px-4 py-2 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-all border border-red-200">
                        ยกเลิกใบลา
                    </button>
                @else
                    <div></div>
                @endif
                <button wire:click="closeDetail"
                    class="px-6 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                    ปิด
                </button>
            </div>
        </div>
    </div>
    @endif

    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
    </style>
</div>
