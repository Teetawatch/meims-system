<div class="min-h-screen bg-slate-50 font-sans flex">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">บันทึกผลการเรียน</h1>
                <p class="text-slate-500 font-medium">จัดการเกรดนักเรียน รายหลักสูตร รุ่น และปีการศึกษา</p>
            </div>

            <div class="flex gap-3">
                <button wire:click="openImportModal"
                    class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-emerald-500/20 transform active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    นำเข้า Excel (.xlsx)
                </button>
                <button wire:click="openModal"
                    class="inline-flex items-center px-6 py-3 bg-slate-900 hover:bg-black text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-slate-900/20 transform active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    เพิ่มเกรดรายบุคคล
                </button>
            </div>
        </header>

        <!-- Filters Section -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2">
                    <label
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">ค้นหานักเรียน
                        / วิชา</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search"
                            placeholder="ชื่อ-นามสกุล, รหัสนักเรียน, รหัสวิชา..."
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">หลักสูตร</label>
                    <select wire:model.live="courseFilter"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 outline-none transition-all">
                        <option value="">ทั้งหมด</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">รุ่น
                        / ปีงบประมาณ</label>
                    <div class="flex gap-2">
                        <select wire:model.live="batchFilter"
                            class="w-1/2 px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 outline-none transition-all text-sm">
                            <option value="">รุ่น</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch }}">{{ $batch }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="yearFilter"
                            class="w-1/2 px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 outline-none transition-all text-sm">
                            <option value="">ปี</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">เทอม</label>
                    <select wire:model.live="semesterFilter"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 outline-none transition-all">
                        <option value="">ทั้งหมด</option>
                        @foreach($semesters as $sem)
                            <option value="{{ $sem }}">{{ $sem }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                นักเรียน</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                กระบวนวิชา</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                เทอม</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                คะแนน</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                เกรด</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($grades as $grade)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 font-black text-xs">
                                            {{ mb_substr($grade->student->first_name_th, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">
                                                {{ $grade->student->first_name_th }} {{ $grade->student->last_name_th }}
                                            </div>
                                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                {{ $grade->student->student_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-700">{{ $grade->subject->subject_name_th }}
                                    </div>
                                    <div class="text-[10px] font-black text-slate-400">{{ $grade->subject->subject_code }}
                                        ({{ $grade->subject->credits }} นก.)</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">
                                        {{ $grade->semester }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="text-sm font-black {{ $grade->score >= 50 ? 'text-emerald-600' : 'text-red-500' }}">
                                        {{ $grade->score ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $gv = $grade->grade !== null ? floatval($grade->grade) : null;
                                        $gradeStyle = match(true) {
                                            $gv === null => 'bg-slate-50 text-slate-400',
                                            $gv >= 3 => 'bg-emerald-50 text-emerald-600',
                                            $gv >= 2 => 'bg-blue-50 text-blue-600',
                                            $gv >= 1 => 'bg-amber-50 text-amber-600',
                                            default => 'bg-red-50 text-red-500',
                                        };
                                    @endphp
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full {{ $gradeStyle }} font-black text-sm">
                                        {{ $grade->grade ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div
                                        class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="edit({{ $grade->id }})"
                                            class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $grade->id }})"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div
                                        class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mx-auto mb-4">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-slate-400 font-bold">ไม่พบข้อมูลผลการเรียน</h3>
                                    <p class="text-slate-400 text-xs mt-1 tracking-tight uppercase font-black">
                                        ลองเปลี่ยนคำค้นหาหรือตัวกรอง</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($grades->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $grades->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- Individual Grade Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-[100] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                    wire:click="$set('isModalOpen', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full relative z-[101]">
                    <div class="px-8 pt-10 pb-6">
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight mb-8">
                            {{ $gradeId ? 'แก้ไขผลการเรียน' : 'บันทึกเกรดใหม่' }}
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">นักเรียน
                                    <span class="text-red-500">*</span></label>
                                <select wire:model="student_id"
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                    <option value="">เลือกนักเรียน</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->student_id }} -
                                            {{ $student->first_name_th }} {{ $student->last_name_th }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id') <span
                                class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">วิชา
                                    <span class="text-red-500">*</span></label>
                                <select wire:model="subject_id"
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                    <option value="">เลือกกระบวนวิชา</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->subject_code }} -
                                            {{ $subject->subject_name_th }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id') <span
                                class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">เทอม
                                        (เช่น 1/2567) <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="semester" placeholder="1/2567"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                    @error('semester') <span
                                    class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">คะแนน
                                        (0-100)</label>
                                    <input type="number" step="0.01" wire:model="score" placeholder="85.50"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                    @error('score') <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">เกรดที่ได้</label>
                                    <select wire:model="grade_value"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                        <option value="">เลือกเกรด</option>
                                        @foreach($allowedGrades as $g)
                                            <option value="{{ $g }}">{{ $g }}</option>
                                        @endforeach
                                    </select>
                                    @error('grade_value') <span
                                    class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50/50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-3">
                            <button type="button" wire:click="save"
                                class="w-full sm:w-auto px-8 py-3 bg-slate-900 text-white text-sm font-black rounded-2xl hover:bg-black transition-all shadow-xl shadow-slate-900/20 transform active:scale-95">
                                บันทึกข้อมูล
                            </button>
                            <button type="button" wire:click="$set('isModalOpen', false)"
                                class="w-full sm:w-auto px-8 py-3 bg-white border border-slate-200 text-sm font-bold text-slate-500 rounded-2xl hover:bg-slate-50 transition-all">
                                ยกเลิก
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    @endif

        <!-- Import Modal -->
        @if($isImportModalOpen)
            <div class="fixed inset-0 z-[100] overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                        wire:click="$set('isImportModalOpen', false)"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                    <div
                        class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full relative z-[101]">
                        <div class="px-8 pt-10 pb-6">
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight mb-4">นำเข้าข้อมูลเกรด (.xlsx)</h3>
                            <p class="text-slate-500 text-sm mb-8 font-medium">นำเข้าคะแนนและเกรดนักเรียนจำนวนมากผ่านไฟล์
                                Excel
                            </p>

                            <div class="mb-6">
                                <button wire:click="downloadTemplate"
                                    class="text-xs font-black text-blue-600 hover:text-blue-800 flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    ดาวน์โหลดไฟล์เทมเพลต (.xlsx)
                                </button>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">เทอม
                                        (เช่น 1/2567) <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="importSemester" placeholder="1/2567"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                    @error('importSemester') <span
                                    class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                </div>

                                <div
                                    class="p-6 border-2 border-dashed border-slate-200 rounded-[2rem] hover:bg-slate-50 transition-colors">
                                    <label class="flex flex-col items-center justify-center cursor-pointer">
                                        <div
                                            class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-black text-slate-700 mb-1">{{ $importFile ? $importFile->getClientOriginalName() : 'เลือกไฟล์ Excel' }}</span>
                                        <span
                                            class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">รองรับไฟล์
                                            .xlsx / .xls</span>
                                        <input type="file" wire:model="importFile" class="hidden">
                                    </label>
                                </div>
                                @error('importFile') <span
                                    class="text-red-500 text-xs mt-1 block text-center font-bold">{{ $message }}</span>
                                @enderror

                                <!-- Table Template Instructions -->
                                <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100/50">
                                    <h5 class="text-xs font-black text-blue-800 uppercase tracking-widest mb-3">
                                        คำแนะนำการจัดเตรียมไฟล์:</h5>
                                    <ul class="text-[10px] font-bold text-blue-700/80 space-y-2 leading-relaxed">
                                        <li class="flex items-center gap-2">
                                            <div class="w-1 h-1 bg-blue-400 rounded-full"></div> หัวตารางต้องมี: <code
                                                class="bg-blue-100 px-1 rounded">student_id</code>, <code
                                                class="bg-blue-100 px-1 rounded">subject_code</code>
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <div class="w-1 h-1 bg-blue-400 rounded-full"></div> ข้อมูลเกรด: <code
                                                class="bg-blue-100 px-1 rounded">score</code> (คะแนน 0-100), <code
                                                class="bg-blue-100 px-1 rounded">grade</code> (ตัวเลข 0, 1, 1.5, 2, 2.5, 3, 3.5, 4)
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <div class="w-1 h-1 bg-blue-400 rounded-full"></div>
                                            ระบบจะรักษารหัสเทอมตามที่คุณระบุไว้ด้านบน
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50/50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-3">
                            <button type="button" wire:click="import" wire:loading.attr="disabled"
                                class="w-full sm:w-auto px-10 py-3 bg-emerald-600 text-white text-sm font-black rounded-2xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20 transform active:scale-95">
                                <span wire:loading.remove>เริ่มการนำเข้าข้อมูล</span>
                                <span wire:loading>กำลังนำเข้า...</span>
                            </button>
                            <button type="button" wire:click="$set('isImportModalOpen', false)"
                                class="w-full sm:w-auto px-8 py-3 bg-white border border-slate-200 text-sm font-bold text-slate-500 rounded-2xl hover:bg-slate-50 transition-all">
                                ยกเลิก
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>