<div class="min-h-screen bg-slate-50 font-['Outfit','Anuphan'] flex">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">จัดการรายวิชา</h1>
                <p class="text-slate-500">จัดการข้อมูลรายวิชาและสรุปหน่วยกิตแยกตามหลักสูตร</p>
            </div>

            <div class="flex items-center space-x-3">
                <button wire:click="openImportModal"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    นำเข้า Excel
                </button>
                <button wire:click="openModal"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    เพิ่มรายวิชาใหม่
                </button>
            </div>
        </header>

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative col-span-2">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="ค้นหา รหัสวิชา, ชื่อวิชา..."
                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <select wire:model.live="searchCourse"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-sm appearance-none">
                    <option value="">ทั้งหมดทุกหลักสูตร</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_name_th }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr
                            class="text-slate-500 text-sm font-semibold uppercase tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4">รหัสวิชา</th>
                            <th class="px-6 py-4">ชื่อวิชา</th>
                            <th class="px-6 py-4">หน่วยกิต</th>
                            <th class="px-6 py-4">อาจารย์ผู้สอน</th>
                            <th class="px-6 py-4">หลักสูตร</th>
                            <th class="px-6 py-4">สถานะ</th>
                            <th class="px-6 py-4 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($subjects as $subject)
                            <tr class="group hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-700">{{ $subject->subject_code }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">{{ $subject->subject_name_th }}</div>
                                    @if($subject->subject_name_en)
                                        <div class="text-xs text-slate-400 capitalize">{{ $subject->subject_name_en }}</div>
                                    @endif
                                </td>
                                    <div
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 ring-1 ring-blue-600/10">
                                        {{ $subject->credits }} หน่วยกิต
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($subject->teacher->count() > 0)
                                        <div class="flex flex-col space-y-1 items-start">
                                            @foreach($subject->teacher->take(2) as $teacher)
                                                <span class="text-xs font-medium text-slate-600 bg-white px-2 py-1 rounded-lg border border-slate-200 shadow-sm">
                                                    {{ $teacher->first_name_th }} {{ $teacher->last_name_th }}
                                                </span>
                                            @endforeach
                                            @if($subject->teacher->count() > 2)
                                                <span class="text-[10px] text-slate-400 pl-1 font-medium">+{{ $subject->teacher->count() - 2 }} ท่าน</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded inline-block">
                                        {{ $subject->course->course_code }}
                                    </div>
                                    <div class="text-xs text-slate-400 mt-0.5">{{ $subject->course->course_name_th }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($subject->is_active)
                                        <span class="inline-flex items-center text-xs font-bold text-green-600">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 anim-pulse"></span>
                                            เปิดสอน
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-xs font-bold text-slate-400">
                                            <span class="w-2 h-2 bg-slate-300 rounded-full mr-1.5"></span>
                                            ปิดสอน
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-1">
                                    <button wire:click="edit({{ $subject->id }})"
                                        class="p-2 text-slate-400 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50"
                                        title="แก้ไข">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $subject->id }})"
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
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 font-medium">ไม่พบข้อมูลรายวิชา</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $subjects->links() }}
            </div>
        </div>
    </main>

    <!-- Entry Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true"
                    wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full relative z-[101]">
                    <div class="bg-white px-8 pt-8 pb-6">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900" id="modal-title">
                                    {{ $isEditMode ? 'แก้ไขข้อมูลรายวิชา' : 'เพิ่มรายวิชาใหม่' }}
                                </h3>
                                <p class="text-sm text-slate-500">กรอกข้อมูลรายละเอียดรายวิชาให้ครบถ้วน</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-1">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">รหัสวิชา <span
                                        class="text-red-500">*</span></label>
                                <input type="text" wire:model="subject_code" placeholder="เช่น ENG101"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                @error('subject_code') <span
                                class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-1">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">หน่วยกิต <span
                                        class="text-red-500">*</span></label>
                                <input type="number" wire:model="credits" min="0"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                @error('credits') <span
                                class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">ชื่อรายวิชา (ภาษาไทย) <span
                                        class="text-red-500">*</span></label>
                                <input type="text" wire:model="subject_name_th" placeholder="ระบุชื่อวิชาเป็นภาษาไทย"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                @error('subject_name_th') <span
                                class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">ชื่อรายวิชา
                                    (ภาษาอังกฤษ)</label>
                                <input type="text" wire:model="subject_name_en" placeholder="Subject Name in English"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                @error('subject_name_en') <span
                                class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">สังกัดหลักสูตร <span
                                        class="text-red-500">*</span></label>
                                <select wire:model="course_id"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all appearance-none">
                                    <option value="">เลือกหลักสูตร</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_name_th }}</option>
                                    @endforeach
                                </select>
                                @error('course_id') <span
                                class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">อาจารย์ผู้สอน</label>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                                    <input type="text" wire:model.live.debounce.300ms="teacherSearch" placeholder="ค้นหาชื่ออาจารย์..."
                                        class="w-full mb-3 px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                                    
                                    <div class="max-h-40 overflow-y-auto space-y-1 pr-2 custom-scrollbar">
                                        @foreach($teachers as $teacher)
                                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded-lg cursor-pointer transition-colors group">
                                                <div class="relative flex items-center">
                                                    <input type="checkbox" wire:model="selectedTeachers" value="{{ $teacher->id }}" 
                                                        class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 transition-all">
                                                </div>
                                                <span class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">
                                                    {{ $teacher->first_name_th }} {{ $teacher->last_name_th }}
                                                </span>
                                            </label>
                                        @endforeach
                                        
                                        @if($teachers->isEmpty())
                                            <div class="text-center py-4 text-slate-400 text-xs">
                                                ไม่พบรายชื่ออาจารย์เริ่มต้นด้วย "{{ $teacherSearch }}"
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">คำอธิบายรายวิชา
                                    (เพิ่มเติม)</label>
                                <textarea wire:model="description" rows="3"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"></textarea>
                            </div>

                            <div class="col-span-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 relative">
                                    </div>
                                    <span class="ml-3 text-sm font-semibold text-slate-700">เปิดการเรียนการสอน
                                        (Active)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-8 py-5 flex items-center justify-end space-x-3">
                        <button type="button" wire:click="closeModal"
                            class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-100 transition-colors">
                            ยกเลิก
                        </button>
                        <button type="button" wire:click="save"
                            class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-colors">
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Import Modal -->
    @if($isImportModalOpen)
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true"
                    wire:click="closeImportModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full relative z-[101]">
                    <div class="bg-white px-8 pt-8 pb-6 text-center">
                        <div
                            class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mx-auto mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">นำเข้าข้อมูลรายวิชา</h3>
                        <p class="text-sm text-slate-500 mb-4">เลือกไฟล์ Excel (.xlsx) เพื่อนำเข้ารายวิชาจำนวนมาก</p>

                        <div class="mb-6">
                            <button wire:click="downloadTemplate"
                                class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center justify-center gap-2 bg-blue-50 px-4 py-2 rounded-xl transition-all mx-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                ดาวน์โหลดไฟล์เทมเพลต (.xlsx)
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-slate-50 border border-slate-200 border-dashed rounded-2xl relative">
                                <input type="file" wire:model="importFile"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="flex flex-col items-center">
                                    <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-slate-600">
                                        @if($importFile)
                                            ไฟล์ที่เลือก: {{ $importFile->getClientOriginalName() }}
                                        @else
                                            คลิกเพื่อเลือกไฟล์ หรือลากไฟล์มาวางที่นี่
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @error('importFile') <p class="text-red-500 text-xs font-semibold">{{ $message }}</p> @enderror

                            <div class="text-left bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                                <h4 class="text-xs font-bold text-blue-700 uppercase mb-2">โครงสร้างไฟล์ที่รองรับ:</h4>
                                <ul class="text-xs text-blue-600 space-y-1 list-disc pl-4">
                                    <li>ต้องมีหัวตาราง (Heading Row) ในบรรทัดแรก</li>
                                    <li>ชื่อคอลัมน์: <b>subject_code</b>, <b>subject_name_th</b>, <b>subject_name_en</b>,
                                        <b>credits</b>, <b>course_code</b>, <b>teacher_codes</b>
                                    </li>
                                    <li><b>course_code</b> ต้องมีอยู่ในระบบแล้ว</li>
                                    <li><b>teacher_codes</b> (ระบุรหัสอาจารย์ คั่นด้วยเครื่องหมายจุลภาค ,)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-8 py-5 flex items-center justify-center space-x-3">
                        <button type="button" wire:click="closeImportModal"
                            class="flex-1 px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-100 transition-colors">
                            ยกเลิก
                        </button>
                        <button type="button" wire:click="import" wire:loading.attr="disabled"
                            class="flex-1 px-6 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-colors disabled:opacity-50">
                            <span wire:loading.remove>เริ่มนำเข้าข้อมูล</span>
                            <span wire:loading>กำลังดำเนินการ...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>