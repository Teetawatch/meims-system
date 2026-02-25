<x-layouts.app>
<div class="min-h-screen bg-background font-body flex" 
     x-data="{ 
        isModalOpen: false, 
        isEditMode: false, 
        courseId: null,
        form: {
            course_code: '',
            course_name_th: '',
            course_name_en: '',
            duration: '',
            academic_year: '',
            fiscal_year_batch: '',
            is_active: true
        },
        openCreateModal() {
            this.isEditMode = false;
            this.courseId = null;
            this.form.course_code = '';
            this.form.course_name_th = '';
            this.form.course_name_en = '';
            this.form.duration = '';
            this.form.academic_year = '';
            this.form.fiscal_year_batch = '';
            this.form.is_active = true;
            this.isModalOpen = true;
        },
        openEditModal(course) {
            this.isEditMode = true;
            this.courseId = course.id;
            this.form.course_code = course.course_code;
            this.form.course_name_th = course.course_name_th;
            this.form.course_name_en = course.course_name_en;
            this.form.duration = course.duration;
            this.form.academic_year = course.academic_year || '';
            this.form.fiscal_year_batch = course.fiscal_year_batch || '';
            this.form.is_active = course.is_active;
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
                <h1 class="text-2xl md:text-3xl font-bold text-text">จัดการข้อมูลหลักสูตร</h1>
                <p class="text-text-muted text-sm font-medium">จัดการรายชื่อหลักสูตรในระบบ</p>
            </div>

            <button @click="openCreateModal()"
                class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl transition-colors shadow-md shadow-primary/20 cursor-pointer">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                เพิ่มหลักสูตรใหม่
            </button>
        </header>

        <!-- Search -->
        <div class="mb-6 flex space-x-4">
            <form action="{{ route('courses.index') }}" method="GET" class="relative flex-1 max-w-lg">
                <input type="text" name="search" value="{{ $search }}" placeholder="ค้นหา รหัสหลักสูตร, ชื่อหลักสูตร..."
                    class="w-full pl-12 pr-4 py-3 bg-white border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all shadow-sm">
                <button type="submit" class="absolute left-4 top-3.5 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

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
            {{-- Automatically open modal if there are errors (assuming it was an add or edit action) --}}
            <script>
                document.addEventListener('alpine:init', () => {
                    setTimeout(() => {
                        let alpineData = Alpine.$data(document.querySelector('[x-data]'));
                        alpineData.isModalOpen = true;
                        // State preservation via old() is handled below in the form
                    }, 100);
                });
            </script>
        @endif

        <!-- Table -->
        <div class="bg-surface rounded-2xl shadow-card border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-hover/50">
                        <tr
                            class="text-text-muted text-xs font-semibold uppercase tracking-wider border-b border-border">
                            <th class="px-6 py-4">รหัสหลักสูตร</th>
                            <th class="px-6 py-4">ชื่อหลักสูตร (TH)</th>
                            <th class="px-6 py-4">ปีการศึกษา</th>
                            <th class="px-6 py-4">รุ่นปี งป.</th>
                            <th class="px-6 py-4">Duration</th>
                            <th class="px-6 py-4">สถานะ</th>
                            <th class="px-6 py-4 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($courses as $course)
                            <tr class="group hover:bg-surface-hover transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-text-secondary text-sm">{{ $course->course_code }}</td>
                                <td class="px-6 py-4 text-text font-medium text-sm">
                                    {{ $course->course_name_th }}
                                    @if($course->course_name_en)
                                        <div class="text-xs text-slate-400">{{ $course->course_name_en }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-text-muted text-sm font-medium">{{ $course->academic_year ?? '-' }}</td>
                                <td class="px-6 py-4 text-text-muted text-sm font-medium">{{ $course->fiscal_year_batch ?? '-' }}</td>
                                <td class="px-6 py-4 text-text-muted text-sm font-medium">{{ $course->duration ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($course->is_active)
                                        <span class="bg-success-light text-success px-2.5 py-1 rounded-lg text-xs font-semibold">Active</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-slate-600/10">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button @click="openEditModal({{ json_encode($course) }})"
                                        class="p-2 text-text-muted cursor-pointer hover:text-primary transition-colors duration-200 rounded-lg hover:bg-info-light"
                                        title="แก้ไข">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบหลักสูตรนี้?');">
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
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        <p>ไม่พบข้อมูลหลักสูตร</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-border">
                {{ $courses->links() }}
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="isModalOpen = false"></div>

            <!-- Modal Panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full relative z-[101]">
                
                <form :action="isEditMode ? '{{ url('courses') }}/' + courseId : '{{ route('courses.store') }}'" method="POST">
                    @csrf
                    <template x-if="isEditMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title" x-text="isEditMode ? 'แก้ไขข้อมูลหลักสูตร' : 'เพิ่มหลักสูตรใหม่'"></h3>
                                
                                <div class="mt-6 space-y-4">
                                    <!-- Code -->
                                    <div>
                                        <label class="block text-sm font-medium text-text-secondary mb-1">รหัสหลักสูตร <span class="text-red-500">*</span></label>
                                        <input type="text" name="course_code" x-model="form.course_code" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                    </div>
                                    
                                    <!-- Name TH -->
                                    <div>
                                        <label class="block text-sm font-medium text-text-secondary mb-1">ชื่อหลักสูตร (TH) <span class="text-red-500">*</span></label>
                                        <input type="text" name="course_name_th" x-model="form.course_name_th" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                    </div>

                                    <!-- Name EN -->
                                    <div>
                                        <label class="block text-sm font-medium text-text-secondary mb-1">ชื่อหลักสูตร (EN)</label>
                                        <input type="text" name="course_name_en" x-model="form.course_name_en" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                    </div>

                                    <!-- Duration -->
                                    <div>
                                        <label class="block text-sm font-medium text-text-secondary mb-1">ระยะเวลา</label>
                                        <input type="text" name="duration" x-model="form.duration" placeholder="เช่น 4 เดือน, 1 ปี" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- Academic Year -->
                                        <div>
                                            <label class="block text-sm font-medium text-text-secondary mb-1">ประจำปีการศึกษา</label>
                                            <input type="text" name="academic_year" x-model="form.academic_year" placeholder="เช่น 2567" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                        </div>

                                        <!-- Fiscal Year Batch -->
                                        <div>
                                            <label class="block text-sm font-medium text-text-secondary mb-1">รุ่นปี งป.</label>
                                            <input type="text" name="fiscal_year_batch" x-model="form.fiscal_year_batch" placeholder="เช่น 67" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" x-model="form.is_active" value="1" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                        <label for="is_active" class="ml-2 block text-sm text-slate-700">ใช้งาน (Active)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                            บันทึก
                        </button>
                        <button type="button" @click="isModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                            ยกเลิก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</x-layouts.app>
