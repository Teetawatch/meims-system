<x-layouts.app>
<div class="min-h-screen bg-background font-body flex" 
     x-data="{ 
        isModalOpen: false, 
        isEditMode: false, 
        isImportModalOpen: false,
        subjectId: null,
        form: {
            subject_code: '',
            subject_name_th: '',
            subject_name_en: '',
            credits: '',
            course_id: '',
            course_id: '',
            description: '',
            is_active: true,
            teacher_ids: []
        },
        openCreateModal() {
            this.isEditMode = false;
            this.subjectId = null;
            this.form.subject_code = '';
            this.form.subject_name_th = '';
            this.form.subject_name_en = '';
            this.form.credits = '';
            this.form.course_id = '';
            this.form.description = '';
            this.form.description = '';
            this.form.is_active = true;
            this.form.teacher_ids = [];
            this.isModalOpen = true;
        },
        openEditModal(subject) {
            this.isEditMode = true;
            this.subjectId = subject.id;
            this.form.subject_code = subject.subject_code;
            this.form.subject_name_th = subject.subject_name_th;
            this.form.subject_name_en = subject.subject_name_en;
            this.form.credits = subject.credits;
            this.form.course_id = subject.course_id;
            this.form.description = subject.description;
            this.form.description = subject.description;
            this.form.is_active = subject.is_active;
            this.form.teacher_ids = subject.teachers ? subject.teachers.map(t => t.id) : [];
            this.isModalOpen = true;
        }
    }">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-text">จัดการรายวิชา</h1>
                <p class="text-text-muted text-sm font-medium">จัดการข้อมูลรายวิชาและสรุปหน่วยกิตแยกตามหลักสูตร</p>
            </div>

            <div class="flex items-center space-x-3">
                <button @click="isImportModalOpen = true"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-emerald-500/30 cursor-pointer">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    นำเข้า Excel
                </button>
                <button @click="openCreateModal()"
                    class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl transition-colors shadow-md shadow-primary/20 cursor-pointer">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    เพิ่มรายวิชาใหม่
                </button>
            </div>
        </header>

        <!-- Filters -->
        <form action="{{ route('subjects.index') }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4" x-ref="filterForm">
            <div class="relative col-span-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="ค้นหา รหัสวิชา, ชื่อวิชา..."
                    class="w-full pl-12 pr-4 py-3 bg-white border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all shadow-sm"
                    @keyup.enter="$refs.filterForm.submit()">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <select name="searchCourse" @change="$refs.filterForm.submit()"
                    class="w-full px-4 py-3 bg-white border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all shadow-sm appearance-none cursor-pointer">
                    <option value="">ทั้งหมดทุกหลักสูตร</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $searchCourse == $course->id ? 'selected' : '' }}>{{ $course->course_name_th }}</option>
                    @endforeach
                </select>
            </div>
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
                            alpineData.isImportModalOpen = true;
                        } else {
                            alpineData.isModalOpen = true;
                        }
                    }, 100);
                });
            </script>
        @endif

        <!-- Table -->
        <div class="bg-surface rounded-2xl shadow-card border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-hover/50">
                        <tr class="text-text-muted text-xs font-semibold uppercase tracking-wider border-b border-border">
                            <th class="px-6 py-4">รหัสวิชา</th>
                            <th class="px-6 py-4">ชื่อวิชา</th>
                            <th class="px-6 py-4">หน่วยกิต</th>
                            <th class="px-6 py-4">หลักสูตร</th>
                            <th class="px-6 py-4">สถานะ</th>
                            <th class="px-6 py-4 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($subjects as $subject)
                            <tr class="group hover:bg-surface-hover transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-700">{{ $subject->subject_code }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">{{ $subject->subject_name_th }}</div>
                                    @if($subject->subject_name_en)
                                        <div class="text-xs text-slate-400 capitalize">{{ $subject->subject_name_en }}</div>
                                    @endif
                                    @if($subject->teachers->count() > 0)
                                        <div class="mt-2 flex flex-wrap gap-1">
                                            @foreach($subject->teachers as $teacher)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-50 text-indigo-700">
                                                    อ.{{ $teacher->first_name_th }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="mt-2 text-[10px] text-slate-400">ยังไม่กำหนดผู้สอน</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 ring-1 ring-blue-600/10">
                                        {{ $subject->credits }} หน่วยกิต
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($subject->course)
                                    <div class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded inline-block">
                                        {{ $subject->course->course_code }}
                                    </div>
                                    <div class="text-xs text-slate-400 mt-0.5">{{ $subject->course->course_name_th }}</div>
                                    @else
                                    <div class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded inline-block">N/A</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($subject->is_active)
                                        <span class="inline-flex items-center text-xs font-bold text-green-600">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
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
                                    <button @click="openEditModal({{ json_encode($subject) }})"
                                        class="p-2 text-text-muted cursor-pointer hover:text-primary transition-colors duration-200 rounded-lg hover:bg-info-light"
                                        title="แก้ไข">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบรายวิชานี้?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-text-muted cursor-pointer hover:text-error transition-colors duration-200 rounded-lg hover:bg-error-light"
                                            title="ลบ">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
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
            <div class="px-6 py-4 border-t border-border">
                {{ $subjects->links() }}
            </div>
        </div>
    </main>

    <!-- Entry Modal -->
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="isModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full relative z-[101]">
                <form :action="isEditMode ? '{{ url('subjects') }}/' + subjectId : '{{ route('subjects.store') }}'" method="POST">
                    @csrf
                    <template x-if="isEditMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div class="bg-white px-8 pt-8 pb-6">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900" id="modal-title" x-text="isEditMode ? 'แก้ไขข้อมูลรายวิชา' : 'เพิ่มรายวิชาใหม่'"></h3>
                                <p class="text-sm text-text-muted text-sm font-medium">กรอกข้อมูลรายละเอียดรายวิชาให้ครบถ้วน</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-1">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">รหัสวิชา <span class="text-red-500">*</span></label>
                                <input type="text" name="subject_code" x-model="form.subject_code" placeholder="เช่น ENG101" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">หน่วยกิต <span class="text-red-500">*</span></label>
                                <input type="number" name="credits" x-model="form.credits" min="0" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">ชื่อรายวิชา (ภาษาไทย) <span class="text-red-500">*</span></label>
                                <input type="text" name="subject_name_th" x-model="form.subject_name_th" placeholder="ระบุชื่อวิชาเป็นภาษาไทย" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">ชื่อรายวิชา (ภาษาอังกฤษ)</label>
                                <input type="text" name="subject_name_en" x-model="form.subject_name_en" placeholder="Subject Name in English" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">สังกัดหลักสูตร <span class="text-red-500">*</span></label>
                                <select name="course_id" x-model="form.course_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                    <option value="">เลือกหลักสูตร</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_name_th }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">อาจารย์ผู้สอนประจำวิชา (เลือกได้มากกว่า 1 ท่าน)</label>
                                <select name="teacher_ids[]" x-model="form.teacher_ids" multiple class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all cursor-pointer h-32">
                                    @foreach($allTeachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->first_name_th }} {{ $teacher->last_name_th }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-slate-500 mt-1">กด Ctrl (หรือ Cmd บน Mac) ค้างไว้เพื่อเลือกหลายรายการ</p>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">คำอธิบายรายวิชา (เพิ่มเติม)</label>
                                <textarea name="description" x-model="form.description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"></textarea>
                            </div>

                            <div class="col-span-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" x-model="form.is_active" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 relative"></div>
                                    <span class="ml-3 text-sm font-semibold text-slate-700">เปิดการเรียนการสอน (Active)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-8 py-5 flex items-center justify-end space-x-3">
                        <button type="button" @click="isModalOpen = false" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                            ยกเลิก
                        </button>
                        <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md shadow-primary/20 transition-colors cursor-pointer">
                            บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div x-show="isImportModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="import-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isImportModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="isImportModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isImportModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full relative z-[101]">
                <form action="{{ route('subjects.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-8 pt-8 pb-6 text-center">
                        <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mx-auto mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2" id="import-modal-title">นำเข้าข้อมูลรายวิชา</h3>
                        <p class="text-sm text-slate-500 mb-4">เลือกไฟล์ Excel (.xlsx) เพื่อนำเข้ารายวิชาจำนวนมาก</p>

                        <div class="mb-6">
                            <a href="{{ route('subjects.template') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center justify-center gap-2 bg-blue-50 px-4 py-2 rounded-xl transition-all mx-auto inline-flex">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                ดาวน์โหลดไฟล์เทมเพลต (.xlsx)
                            </a>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-slate-50 border border-slate-200 border-dashed rounded-2xl relative">
                                <input type="file" name="importFile" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".xlsx,.xls,.csv" onchange="document.getElementById('fileName').textContent = this.files[0] ? 'ไฟล์ที่เลือก: ' + this.files[0].name : 'คลิกเพื่อเลือกไฟล์ หรือลากไฟล์มาวางที่นี่'">
                                <div class="flex flex-col items-center">
                                    <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span id="fileName" class="text-sm font-medium text-slate-600">
                                        คลิกเพื่อเลือกไฟล์ หรือลากไฟล์มาวางที่นี่
                                    </span>
                                </div>
                            </div>

                            <div class="text-left bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                                <h4 class="text-xs font-bold text-blue-700 uppercase mb-2">โครงสร้างไฟล์ที่รองรับ:</h4>
                                <ul class="text-xs text-blue-600 space-y-1 list-disc pl-4">
                                    <li>ต้องมีหัวตาราง (Heading Row) ในบรรทัดแรก</li>
                                    <li>ชื่อคอลัมน์: <b>subject_code</b>, <b>subject_name_th</b>, <b>subject_name_en</b>, <b>credits</b>, <b>course_code</b></li>
                                    <li><b>course_code</b> ต้องมีอยู่ในระบบแล้ว</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-8 py-5 flex items-center justify-center space-x-3">
                        <button type="button" @click="isImportModalOpen = false" class="flex-1 px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                            ยกเลิก
                        </button>
                        <button type="submit" class="flex-1 px-6 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-colors cursor-pointer">
                            เริ่มนำเข้าข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
