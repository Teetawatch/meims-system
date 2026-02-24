<x-layouts.app>
<div class="min-h-screen bg-background font-body flex"
     x-data="{ 
         showImportModal: false, 
         fileName: null, 
         selectedStudents: [], 
         selectAll: false,
         toggleSelectAll(event) {
             const checkboxes = document.querySelectorAll('.student-checkbox');
             if (event.target.checked) {
                 this.selectedStudents = Array.from(checkboxes).map(el => el.value);
             } else {
                 this.selectedStudents = [];
             }
         }
     }">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 p-4 md:p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-text">จัดการข้อมูลนักเรียน</h1>
                <p class="text-text-muted text-sm font-medium mt-1">รายชื่อนักเรียนทั้งหมดและเครื่องมือจัดการ</p>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('students.template') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-surface text-text-secondary border border-border hover:bg-surface-hover hover:border-border-hover text-sm font-medium rounded-xl transition-all duration-200 shadow-sm cursor-pointer">
                    <svg class="w-4 h-4 mr-2 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    โหลดไฟล์แบบฟอร์ม
                </a>

                <!-- Trigger Button -->
                <button @click="showImportModal = true"
                    class="inline-flex items-center px-4 py-2.5 bg-info-light text-primary border border-blue-200 hover:bg-blue-100 text-sm font-medium rounded-xl transition-all duration-200 shadow-sm cursor-pointer">
                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    นำเข้าข้อมูล
                </button>

                <a href="{{ route('student.register') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-md shadow-primary/20 cursor-pointer">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    เพิ่มข้อมูลนักเรียน
                </a>
            </div>
        </header>

        <!-- Search & Filter -->
        <form action="{{ route('students.index') }}" method="GET" class="mb-6 flex flex-wrap gap-3 items-center" x-ref="filterForm">
            <div class="relative flex-1 min-w-[250px] max-w-lg">
                <label for="student-search" class="sr-only">ค้นหานักเรียน</label>
                <input type="text" id="student-search" name="search" value="{{ $search }}" placeholder="ค้นหา ชื่อ, นามสกุล, หรือ รหัสนักเรียน..."
                    class="w-full pl-10 pr-4 py-2.5 bg-surface border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 shadow-sm text-sm"
                    @keyup.enter="$refs.filterForm.submit()">
                <svg class="w-4 h-4 text-text-disabled absolute left-3.5 top-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <label for="course-filter" class="sr-only">กรองตามหลักสูตร</label>
            <select id="course-filter" name="courseFilter" @change="$refs.filterForm.submit()"
                class="px-4 py-2.5 bg-surface border border-border rounded-xl text-sm text-text-secondary focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none shadow-sm cursor-pointer transition-all duration-200">
                <option value="">ทุกหลักสูตร</option>
                @foreach($courses as $course)
                    <option value="{{ $course }}" {{ $courseFilter == $course ? 'selected' : '' }}>{{ $course }}</option>
                @endforeach
            </select>

            <label for="batch-filter" class="sr-only">กรองตามรุ่น</label>
            <select id="batch-filter" name="batchFilter" @change="$refs.filterForm.submit()"
                class="px-4 py-2.5 bg-surface border border-border rounded-xl text-sm text-text-secondary focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none shadow-sm cursor-pointer transition-all duration-200">
                <option value="">ทุกรุ่น</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch }}" {{ $batchFilter == $batch ? 'selected' : '' }}>รุ่น {{ $batch }}</option>
                @endforeach
            </select>
        </form>

        @if (session('message'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <strong>พบข้อผิดพลาด:</strong>
                </div>
                <ul class="list-disc list-inside text-sm pl-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div id="error-data" data-has-import-error="{{ $errors->has('importFile') ? 'true' : 'false' }}" style="display: none;"></div>
            <script>
                document.addEventListener('alpine:init', () => {
                    setTimeout(() => {
                        let alpineData = Alpine.$data(document.querySelector('[x-data]'));
                        let dataElement = document.getElementById('error-data');
                        if (dataElement && dataElement.dataset.hasImportError === 'true') {
                            alpineData.showImportModal = true;
                        }
                    }, 100);
                });
            </script>
        @endif

        <!-- Bulk Action Bar -->
        <div x-show="selectedStudents.length > 0" class="mb-4 flex items-center justify-between bg-error-light border border-red-200 rounded-xl px-5 py-3 animate-fade-in" role="alert" style="display: none;">
            <div class="flex items-center gap-2 text-sm text-error">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold">เลือกแล้ว <span x-text="selectedStudents.length"></span> คน</span>
            </div>
            <div class="flex items-center gap-2">
                <button @click="selectedStudents = []; selectAll = false"
                    class="px-4 py-2 text-sm text-text-secondary hover:bg-surface border border-border rounded-xl transition-all duration-200 cursor-pointer">
                    ยกเลิกการเลือก
                </button>
                <form action="{{ route('students.destroySelected') }}" method="POST" class="inline-block" onsubmit="return confirm('คุณต้องการลบนักเรียนที่เลือกทั้งหมดใช่หรือไม่?');">
                    @csrf
                    @method('DELETE')
                    <template x-for="id in selectedStudents">
                        <input type="hidden" name="selectedStudents[]" :value="id">
                    </template>
                    <button type="submit"
                        class="px-4 py-2 text-sm text-white bg-error hover:bg-red-700 rounded-xl transition-all duration-200 shadow-sm font-medium flex items-center cursor-pointer">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        ลบที่เลือก
                    </button>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-surface rounded-2xl shadow-card border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-hover/50">
                        <tr class="text-text-muted text-xs font-semibold uppercase tracking-wider border-b border-border">
                            <th class="px-5 py-4 w-12">
                                <input type="checkbox" x-model="selectAll" @change="toggleSelectAll($event)"
                                    class="rounded border-border text-primary focus:ring-primary/20 cursor-pointer">
                            </th>
                            <th class="px-5 py-4">รูปภาพ</th>
                            <th class="px-5 py-4">รหัสนักเรียน</th>
                            <th class="px-5 py-4">ชื่อ - สกุล</th>
                            <th class="px-5 py-4">รุ่น</th>
                            <th class="px-5 py-4">สถานะ</th>
                            <th class="px-5 py-4 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($students as $student)
                            <tr class="group hover:bg-surface-hover transition-colors duration-200" :class="{ 'bg-info-light/30': selectedStudents.includes('{{ $student->id }}') }">
                                <td class="px-5 py-4">
                                    <input type="checkbox" value="{{ $student->id }}" x-model="selectedStudents"
                                        class="student-checkbox rounded border-border text-primary focus:ring-primary/20 cursor-pointer">
                                </td>
                                <td class="px-5 py-4">
                                    @if($student->photo_path)
                                        <img src="{{ asset('storage/' . $student->photo_path) }}"
                                            class="w-10 h-10 rounded-xl object-cover border border-border"
                                            alt="{{ $student->first_name_th }}">
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-surface-hover flex items-center justify-center text-text-muted">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 font-medium text-text-secondary text-sm">{{ $student->student_id }}</td>
                                <td class="px-5 py-4 text-text font-medium text-sm">
                                    {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}
                                </td>
                                <td class="px-5 py-4 text-text-muted text-sm">{{ $student->batch }}</td>
                                <td class="px-5 py-4">
                                    <span class="bg-success-light text-success px-2.5 py-1 rounded-lg text-xs font-semibold">ปกติ</span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('students.show', $student->id) }}"
                                            class="p-2 text-text-muted hover:text-primary transition-colors duration-200 rounded-lg hover:bg-info-light cursor-pointer"
                                            title="ดูรายละเอียด">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('ยืนยันการลบข้อมูลนักเรียนรายนี้?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-text-muted hover:text-error transition-colors duration-200 rounded-lg hover:bg-error-light cursor-pointer"
                                                title="ลบ">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 bg-surface-hover rounded-full flex items-center justify-center">
                                            <svg class="w-7 h-7 text-text-disabled" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-text-muted font-medium text-sm">ไม่พบข้อมูลนักเรียน</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-border">
                {{ $students->links() }}
            </div>
        </div>
    </main>

    <!-- Modal Backdrop -->
    <div x-show="showImportModal" x-transition.opacity
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        style="display: none;">
        
        <!-- Modal Content -->
        <div x-show="showImportModal" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.away="showImportModal = false"
            class="bg-surface rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-border">
            
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Header -->
                <div class="px-6 py-5 border-b border-border flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-info-light rounded-xl text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-text">นำเข้าข้อมูลนักเรียน</h3>
                            <p class="text-sm text-text-muted">อัปโหลดไฟล์ Excel หรือ CSV เพื่อนำเข้า</p>
                        </div>
                    </div>
                    <button type="button" @click="showImportModal = false" class="text-text-muted hover:text-text transition-colors duration-200 p-1.5 rounded-lg hover:bg-surface-hover cursor-pointer"
                        aria-label="ปิด">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-4">
                    <!-- Upload Area -->
                    <div class="relative">
                        <input type="file" name="importFile" id="modalImportFile" class="hidden" accept=".xlsx,.xls,.csv" required
                                x-on:change="fileName = $event.target.files[0] ? $event.target.files[0].name : null">
                        
                        <label for="modalImportFile" 
                                class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-border rounded-2xl hover:bg-info-light/30 hover:border-primary/40 transition-all duration-200 cursor-pointer group relative overflow-hidden bg-surface-hover/50">
                            
                            <!-- Default State -->
                            <div x-show="!fileName" class="flex flex-col items-center text-center p-6 transition-transform duration-200 group-hover:-translate-y-0.5">
                                <div class="w-14 h-14 bg-surface shadow-sm border border-border rounded-xl flex items-center justify-center mb-4 text-primary group-hover:scale-105 transition-transform duration-200">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-text mb-1">คลิกเพื่อเลือกไฟล์</h4>
                                <p class="text-sm text-text-muted">หรือลากไฟล์มาวางที่นี่</p>
                                <p class="text-xs text-text-disabled mt-2 bg-surface px-2 py-1 rounded-md border border-border">.xlsx, .xls, .csv</p>
                            </div>

                            <!-- Selected State -->
                            <div x-show="fileName" class="flex flex-col items-center w-full h-full justify-center p-6 bg-surface" style="display: none;">
                                <div class="w-full max-w-sm bg-surface-hover border border-border rounded-xl p-4 flex items-center shadow-sm relative overflow-hidden">
                                    <div class="w-10 h-10 bg-surface rounded-lg flex items-center justify-center text-success shadow-sm border border-success-light mr-3 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-text truncate" x-text="fileName">example.xlsx</p>
                                        <div class="flex justify-between items-center mt-1">
                                            <span class="text-xs text-success font-medium">พร้อมนำเข้า</span>
                                            <span @click.prevent="fileName = null; document.getElementById('modalImportFile').value = '';" class="text-xs text-error hover:text-red-700 cursor-pointer hover:underline">เปลี่ยนไฟล์</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="bg-warning-light border border-amber-200 rounded-xl p-4 flex gap-3">
                        <div class="shrink-0 text-warning">
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
                <div class="px-6 py-4 bg-surface-hover/50 border-t border-border flex justify-end gap-3">
                    <button type="button" @click="showImportModal = false; fileName = null;" 
                        class="px-5 py-2.5 text-text-secondary hover:bg-surface hover:border-border-hover border border-transparent font-medium rounded-xl text-sm transition-all duration-200 cursor-pointer">
                        ยกเลิก
                    </button>
                    <button type="submit" x-show="fileName"
                        class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl text-sm transition-all duration-200 shadow-md shadow-primary/20 flex items-center hover:-translate-y-0.5 cursor-pointer">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            ยืนยันการนำเข้า
                        </span>
                    </button>
                    <button type="button" x-show="!fileName" disabled
                        class="px-4 py-2.5 bg-surface-hover text-text-disabled font-medium rounded-xl text-sm cursor-not-allowed border border-border">
                        ยืนยันการนำเข้า
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>
