<div class="min-h-screen bg-slate-50 font-sans flex">

    <!-- Sidebar Container -->
    <aside
        class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">จัดการข้อมูลนักเรียน</h1>
                <p class="text-slate-500">รายชื่อนักเรียนทั้งหมดและเครื่องมือจัดการ</p>
            </div>

            <div class="flex items-center space-x-3">
                <button wire:click="downloadTemplate"
                    class="inline-flex items-center px-4 py-2 bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 text-sm font-medium rounded-xl transition-all shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    โหลดไฟล์แบบฟอร์ม
                </button>

                <!-- Import Button & Modal -->
                <div x-data="{ showImportModal: false, uploading: false, progress: 0, fileName: null }"
                     x-on:close-import-modal.window="showImportModal = false; fileName = null;"
                     class="relative">
                    
                    <!-- Trigger Button -->
                    <button @click="showImportModal = true; fileName = null;" 
                        wire:click="$set('importFile', null)"
                        class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 text-sm font-medium rounded-xl transition-all shadow-sm">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        นำเข้าข้อมูล
                    </button>

                    <!-- Modal Backdrop -->
                    <div x-show="showImportModal" x-transition.opacity
                        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[60] flex items-center justify-center p-4"
                        style="display: none;">
                        
                        <!-- Modal Content -->
                        <div x-show="showImportModal" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            @click.away="if(!uploading) showImportModal = false"
                            class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-slate-100">
                            
                            <!-- Header -->
                            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-800">นำเข้าข้อมูลนักเรียน</h3>
                                        <p class="text-sm text-slate-500">อัปโหลดไฟล์ Excel หรือ CSV เพื่อนำเข้า</p>
                                    </div>
                                </div>
                                <button @click="if(!uploading) showImportModal = false" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-full hover:bg-slate-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="p-6 space-y-4">
                                <!-- Upload Area -->
                                <div x-on:livewire-upload-start="uploading = true; progress = 0"
                                     x-on:livewire-upload-finish="uploading = false"
                                     x-on:livewire-upload-error="uploading = false; fileName = null"
                                     x-on:livewire-upload-progress="progress = $event.detail.progress"
                                     class="relative">
                                    
                                    <input type="file" wire:model="importFile" id="modalImportFile" class="hidden" accept=".xlsx,.xls,.csv"
                                           x-on:change="fileName = $event.target.files[0] ? $event.target.files[0].name : null">
                                    
                                    <label for="modalImportFile" 
                                           class="flex flex-col items-center justify-center w-full h-52 border-2 border-dashed border-slate-300 rounded-2xl hover:bg-indigo-50/50 hover:border-indigo-400 transition-all cursor-pointer group relative overflow-hidden bg-slate-50">
                                        
                                        <!-- Default State -->
                                        <div x-show="!fileName && !uploading" class="flex flex-col items-center text-center p-6 transition-transform duration-300 group-hover:-translate-y-1">
                                            <div class="w-16 h-16 bg-white shadow-sm border border-slate-100 rounded-2xl flex items-center justify-center mb-4 text-indigo-500 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-base font-semibold text-slate-700 mb-1">คลิกเพื่อเลือกไฟล์</h4>
                                            <p class="text-sm text-slate-500">หรือลากไฟล์มาวางที่นี่</p>
                                            <p class="text-xs text-slate-400 mt-2 bg-white px-2 py-1 rounded border border-slate-100">.xlsx, .xls, .csv</p>
                                        </div>

                                        <!-- Selected/Uploading State -->
                                        <div x-show="fileName || uploading" class="flex flex-col items-center w-full h-full justify-center p-6 bg-white" style="display: none;">
                                            <div class="w-full max-w-sm bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center shadow-sm relative overflow-hidden">
                                                <!-- Progress Bar Background (Fills the card) -->
                                                <div x-show="uploading" class="absolute bottom-0 left-0 h-1 bg-indigo-500 transition-all duration-300" :style="`width: ${progress}%`"></div>

                                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-green-500 shadow-sm border border-green-100 mr-3 shrink-0">
                                                    <svg x-show="!uploading" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <svg x-show="uploading" class="w-6 h-6 animate-spin text-indigo-500" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                </div>
                                                
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-slate-700 truncate" x-text="fileName || 'กำลังเตรียมไฟล์...'">example.xlsx</p>
                                                    <div class="flex justify-between items-center mt-1">
                                                        <span x-show="uploading" class="text-xs text-indigo-600 font-medium" x-text="`กำลังอัปโหลด... ${progress}%`"></span>
                                                        <span x-show="!uploading" class="text-xs text-green-600 font-medium">พร้อมนำเข้า</span>
                                                        
                                                        <span x-show="!uploading" 
                                                              @click.prevent="fileName = null; document.getElementById('modalImportFile').value = '';" 
                                                              wire:click="$set('importFile', null)"
                                                              class="text-xs text-red-400 hover:text-red-600 cursor-pointer hover:underline">เปลี่ยนไฟล์</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                @error('importFile')
                                    <div class="text-center p-2 bg-red-50 border border-red-100 rounded-xl text-red-600 text-xs font-bold animate-pulse">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 flex gap-3">
                                    <div class="shrink-0 text-amber-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-sm text-amber-800">
                                        <p class="font-medium mb-1">คำแนะนำ</p>
                                        <p class="text-amber-700/80 leading-relaxed text-xs">เพื่อให้การนำเข้าข้อมูลถูกต้อง กรุณาใช้ไฟล์แบบฟอร์มที่ดาวน์โหลดจากระบบ หากมีข้อมูลซ้ำ ระบบจะทำการอัปเดตข้อมูลเดิมให้เป็นปัจจุบัน</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end space-x-3">
                                <button @click="if(!uploading) { showImportModal = false; fileName = null; }" 
                                    wire:click="$set('importFile', null)"
                                    class="px-5 py-2.5 text-slate-600 hover:bg-white hover:border-slate-300 border border-transparent font-medium rounded-xl text-sm transition-all"
                                    :disabled="uploading">
                                    ยกเลิก
                                </button>
                                
                                <!-- Active Confirm Button: Visible when file is uploaded to server and not currently uploading -->
                                <button x-show="fileName && !uploading"
                                    wire:click="import" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl text-sm transition-all shadow-lg shadow-indigo-500/30 flex items-center hover:-translate-y-0.5"
                                    wire:loading.attr="disabled"
                                    wire:target="import">
                                    <span wire:loading.remove wire:target="import" class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        ยืนยันการนำเข้า
                                    </span>
                                    <span wire:loading wire:target="import" class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        กำลังนำเข้า...
                                    </span>
                                </button>
                                
                                <!-- Disabled placeholder button: Visible when no file selected or file still uploading -->
                                <button x-show="!fileName || uploading" disabled
                                    class="px-5 py-2.5 bg-slate-200 text-slate-400 font-medium rounded-xl text-sm cursor-not-allowed">
                                    <span x-show="uploading">กำลังอัปโหลดไฟล์...</span>
                                    <span x-show="!uploading">ยืนยันการนำเข้า</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('student.register') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    เพิ่มข้อมูลนักเรียน
                </a>
            </div>
        </header>

        <!-- Search & Filter -->
        <div class="mb-6 flex flex-wrap gap-4 items-center">
            <div class="relative flex-1 min-w-[250px] max-w-lg">
                <input type="text" wire:model.live="search" placeholder="ค้นหา ชื่อ, นามสกุล, หรือ รหัสนักเรียน..."
                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <select wire:model.live="courseFilter"
                class="px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none shadow-sm">
                <option value="">ทุกหลักสูตร</option>
                @foreach($courses as $course)
                    <option value="{{ $course }}">{{ $course }}</option>
                @endforeach
            </select>

            <select wire:model.live="batchFilter"
                class="px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none shadow-sm">
                <option value="">ทุกรุ่น</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch }}">รุ่น {{ $batch }}</option>
                @endforeach
            </select>
        </div>

        <!-- Bulk Action Bar -->
        @if(count($selectedStudents) > 0)
        <div class="mb-4 flex items-center justify-between bg-red-50 border border-red-200 rounded-xl px-5 py-3 animate-in fade-in">
            <div class="flex items-center space-x-2 text-sm text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold">เลือกแล้ว {{ count($selectedStudents) }} คน</span>
            </div>
            <div class="flex items-center space-x-3">
                <button wire:click="$set('selectedStudents', []); $set('selectAll', false)"
                    class="px-4 py-2 text-sm text-slate-600 hover:bg-white border border-slate-200 rounded-xl transition-all">
                    ยกเลิกการเลือก
                </button>
                <button
                    @click="Swal.fire({ title: 'ยืนยันการลบ?', text: 'คุณต้องการลบนักเรียนที่เลือก {{ count($selectedStudents) }} คน?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#d1d5db', confirmButtonText: 'ใช่, ลบเลย!', cancelButtonText: 'ยกเลิก' }).then((result) => { if (result.isConfirmed) { $wire.deleteSelected(); } })"
                    class="px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-xl transition-all shadow-sm font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    ลบที่เลือก
                </button>
            </div>
        </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr
                            class="text-slate-500 text-sm font-semibold uppercase tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4 w-12">
                                <input type="checkbox" wire:model.live="selectAll"
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-4">รูปภาพ</th>
                            <th class="px-6 py-4">รหัสนักเรียน</th>
                            <th class="px-6 py-4">ชื่อ - สกุล</th>
                            <th class="px-6 py-4">รุ่น</th>
                            <th class="px-6 py-4">สถานะ</th>
                            <th class="px-6 py-4 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $student)
                            <tr class="group hover:bg-slate-50/80 transition-colors {{ in_array((string)$student->id, $selectedStudents) ? 'bg-blue-50/50' : '' }}">
                                <td class="px-6 py-4">
                                    <input type="checkbox" wire:model.live="selectedStudents" value="{{ $student->id }}"
                                        class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4">
                                    @if($student->photo_path)
                                        <img src="{{ asset('images/students/' . $student->photo_path) }}"
                                            class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700">{{ $student->student_id }}</td>
                                <td class="px-6 py-4 text-slate-600 font-medium">
                                    {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $student->batch }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-green-600/10">ปกติ</span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('students.show', $student->id) }}"
                                        class="inline-block p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-indigo-50"
                                        title="ดูรายละเอียด">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('students.edit', $student->id) }}"
                                        class="p-2 text-slate-400 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50 inline-block"
                                        title="แก้ไข">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </a>
                                    <button wire:click="delete({{ $student->id }})" wire:confirm="ยืนยันการลบข้อมูล?"
                                        class="p-2 text-slate-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50"
                                        title="ลบ">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p>ไม่พบข้อมูลนักเรียน</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $students->links() }}
            </div>
        </div>
    </main>
</div>