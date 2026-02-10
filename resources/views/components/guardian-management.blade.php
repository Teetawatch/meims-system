<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">จัดการข้อมูลผู้ปกครอง</h2>
        <button wire:click="create"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            เพิ่มผู้ปกครอง
        </button>
    </div>

    <!-- Search & Filters -->
    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex gap-4">
        <div class="flex-1 relative">
            <svg class="w-5 h-5 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" 
                class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder:text-slate-400"
                placeholder="ค้นหาชื่อผู้ปกครอง, ชื่อผู้ใช้...">
        </div>
    </div>

    <!-- Guardian Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ชื่อ-นามสกุล</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ชื่อผู้ใช้ (Username)</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">บทบาท</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">เบอร์โทร</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">บุตรหลานในความดูแล</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($guardians as $guardian)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700">{{ $guardian->title_th }}{{ $guardian->first_name_th }} {{ $guardian->last_name_th }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 font-mono">{{ $guardian->username }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $guardian->relationship ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $guardian->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($guardian->students->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($guardian->students as $child)
                                            <span class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-md border border-blue-100">
                                                {{ $child->first_name_th }} ({{ $child->student_id }})
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">ยังไม่มีข้อมูล</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="edit({{ $guardian->id }})" 
                                    class="text-amber-600 hover:text-amber-700 font-medium text-sm mr-3 transition-colors">
                                    แก้ไข/ผูกบัญชี
                                </button>
                                <button wire:click="confirmDelete({{ $guardian->id }})" 
                                    class="text-red-500 hover:text-red-600 font-medium text-sm transition-colors">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium italic">
                                ไม่พบข้อมูลผู้ปกครอง
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $guardians->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm transition-opacity"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all"
                @click.away="showModal = false">
                
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white z-10">
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ $isEdit ? 'แก้ไขข้อมูลผู้ปกครอง' : 'เพิ่มผู้ปกครองใหม่' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Account Info -->
                    <div>
                        <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">ข้อมูลบัญชีผู้ใช้</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">ชื่อผู้ใช้ (Username) <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="username" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-mono placeholder:font-sans">
                                @error('username') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">
                                    รหัสผ่าน 
                                    @if($isEdit)
                                        <span class="text-xs text-slate-400 font-normal">(เว้นว่างไว้หากไม่เปลี่ยน)</span>
                                    @else
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <input type="password" wire:model="password" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="••••••••">
                                @error('password') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div>
                        <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">ข้อมูลส่วนตัว</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">คำนำหน้า</label>
                                <select wire:model="title_th" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">เลือก...</option>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">ชื่อจริง <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="first_name_th" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                @error('first_name_th') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">นามสกุล <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="last_name_th" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                @error('last_name_th') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">เบอร์โทรศัพท์</label>
                                <input type="text" wire:model="phone" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">ความสัมพันธ์กับนักเรียน</label>
                                <select wire:model="relationship" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">เลือก...</option>
                                    <option value="บิดา">บิดา</option>
                                    <option value="มารดา">มารดา</option>
                                    <option value="ผู้ปกครอง">ผู้ปกครอง</option>
                                    <option value="ญาติ">ญาติ</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Manage Children (Linking) -->
                    <div>
                        <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">จัดการบุตรหลานในความดูแล</h4>
                        
                        <!-- Search Box -->
                        <div class="relative mb-4">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">ค้นหาและเพิ่มนักเรียน</label>
                            <input type="text" wire:model.live.debounce.300ms="studentSearch" 
                                class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder:text-slate-400"
                                placeholder="พิมพ์ชื่อนักเรียน หรือรหัสประจำตัว...">
                            <svg class="w-5 h-5 absolute left-3 top-9 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        
                            <!-- Search Results Dropdown -->
                            @if(!empty($searchResults))
                                <div class="absolute z-20 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                    @foreach($searchResults as $result)
                                        <button type="button" wire:click="addStudent({{ $result['id'] }})" 
                                            class="w-full text-left px-4 py-2 hover:bg-slate-50 transition-colors flex justify-between items-center group">
                                            <div>
                                                <span class="font-bold text-slate-700 block">{{ $result['first_name_th'] }} {{ $result['last_name_th'] }}</span>
                                                <span class="text-xs text-slate-500 font-mono">{{ $result['student_id'] }}</span>
                                            </div>
                                            <span class="text-xs text-emerald-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">เลือก +</span>
                                        </button>
                                    @endforeach
                                </div>
                            @elseif(strlen($studentSearch) >= 2)
                                <div class="absolute z-20 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg p-3 text-center text-slate-500 text-sm italic">
                                    ไม่พบนักเรียนที่ค้นหา
                                </div>
                            @endif
                        </div>

                        <!-- Selected List -->
                        <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 min-h-[100px]">
                            @if(count($selectedStudents) > 0)
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($this->selectedStudentsList as $student)
                                        <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                                    {{ mb_substr($student->first_name_th, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-700">{{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</p>
                                                    <p class="text-[10px] text-slate-500 font-mono">{{ $student->student_id }}</p>
                                                </div>
                                            </div>
                                            <button wire:click="removeStudent({{ $student->id }})" class="text-red-400 hover:text-red-600 transition-colors p-1 rounded-full hover:bg-red-50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-slate-400 py-4">
                                    <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span class="text-sm font-medium">ยังไม่ได้ผูกบัญชีกับนักเรียน</span>
                                    <span class="text-xs mt-1">ค้นหาชื่อนักเรียนด้านบนเพื่อเพิ่ม</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3 bg-slate-50 sticky bottom-0 rounded-b-2xl">
                    <button wire:click="$set('showModal', false)" 
                        class="px-4 py-2 text-slate-600 font-medium hover:bg-slate-200 rounded-lg transition-colors">
                        ยกเลิก
                    </button>
                    <button wire:click="save" 
                        class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all transform active:scale-95">
                        {{ $isEdit ? 'บันทึกการเปลี่ยนแปลง' : 'ยืนยันการเพิ่มข้อมูล' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
