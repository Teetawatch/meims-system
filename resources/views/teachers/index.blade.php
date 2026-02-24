<x-layouts.app>
<div class="min-h-screen bg-background font-body flex" 
     x-data="{ 
        isModalOpen: false, 
        isEditMode: false, 
        teacherId: null,
        showImportModal: false,
        fileName: null,
        form: {
            teacher_code: '',
            title_th: '',
            first_name_th: '',
            last_name_th: '',
            position: '',
            email: '',
            phone: ''
        },
        openCreateModal() {
            this.isEditMode = false;
            this.teacherId = null;
            this.form.teacher_code = '';
            this.form.title_th = '';
            this.form.first_name_th = '';
            this.form.last_name_th = '';
            this.form.position = '';
            this.form.email = '';
            this.form.phone = '';
            this.isModalOpen = true;
        },
        openEditModal(teacher) {
            this.isEditMode = true;
            this.teacherId = teacher.id;
            this.form.teacher_code = teacher.teacher_code;
            this.form.title_th = teacher.title_th;
            this.form.first_name_th = teacher.first_name_th;
            this.form.last_name_th = teacher.last_name_th;
            this.form.position = teacher.position;
            this.form.email = teacher.email;
            this.form.phone = teacher.phone;
            this.isModalOpen = true;
        }
    }">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-4 md:p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-text">จัดการข้อมูลอาจารย์</h1>
                <p class="text-text-muted text-sm font-medium mt-1">จัดการรายชื่ออาจารย์ผู้สอนและการตั้งค่าต่างๆ</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('teachers.template') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-surface text-text-secondary border border-border hover:bg-surface-hover text-sm font-semibold rounded-xl transition-all duration-200 shadow-sm cursor-pointer">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    โหลดฟอร์ม
                </a>
                <button @click="showImportModal = true"
                    class="inline-flex items-center px-4 py-2.5 bg-info-light text-primary border border-blue-200 hover:bg-blue-100 text-sm font-semibold rounded-xl transition-all duration-200 shadow-sm cursor-pointer">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    นำเข้าข้อมูล
                </button>
                <button @click="openCreateModal()"
                    class="inline-flex items-center px-5 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-md shadow-primary/20 cursor-pointer active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    เพิ่มอาจารย์ใหม่
                </button>
            </div>
        </header>

        <!-- Error handling for import -->
        @if ($errors->has('importFile'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="font-bold text-sm">การนำเข้าข้อมูลล้มเหลว</p>
                <p class="text-xs mt-1">{{ $errors->first('importFile') }}</p>
            </div>
        </div>
        @endif

        <!-- Search Section -->
        <div class="bg-surface p-5 rounded-2xl shadow-card border border-border mb-6">
            <form action="{{ route('teachers.index') }}" method="GET" class="relative" x-ref="searchForm">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-disabled">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search }}" placeholder="ค้นหา ชื่อ-นามสกุล, รหัสอาจารย์..."
                    class="w-full pl-11 pr-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:bg-surface focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 text-sm"
                    @keyup.enter="$refs.searchForm.submit()">
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
            <script>
                document.addEventListener('alpine:init', () => {
                    setTimeout(() => {
                        let alpineData = Alpine.$data(document.querySelector('[x-data]'));
                        alpineData.isModalOpen = true;
                    }, 100);
                });
            </script>
        @endif

        <!-- Table -->
        <div class="bg-surface rounded-2xl shadow-card border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-hover/50">
                            <th class="px-6 py-4 text-xs font-semibold text-text-muted uppercase tracking-wider border-b border-border">
                                อาจารย์</th>
                            <th class="px-6 py-4 text-xs font-semibold text-text-muted uppercase tracking-wider border-b border-border">
                                ตำแหน่ง</th>
                            <th class="px-6 py-4 text-xs font-semibold text-text-muted uppercase tracking-wider border-b border-border">
                                ติดต่อ</th>
                            <th class="px-6 py-4 text-xs font-semibold text-text-muted uppercase tracking-wider border-b border-border text-right">
                                การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($teachers as $teacher)
                            <tr class="hover:bg-surface-hover transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-info-light rounded-xl flex items-center justify-center text-primary font-semibold text-sm">
                                            {{ mb_substr($teacher->first_name_th, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-text">
                                                {{ $teacher->title_th }}{{ $teacher->first_name_th }}
                                                {{ $teacher->last_name_th }}</div>
                                            <div class="text-xs font-medium text-text-muted uppercase tracking-wider">
                                                {{ $teacher->teacher_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 bg-surface-hover rounded-lg text-xs font-semibold text-text-secondary">{{ $teacher->position ?? 'อาจารย์ผู้สอน' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-semibold text-text-secondary">{{ $teacher->email ?? '-' }}</div>
                                    <div class="text-xs font-medium text-text-muted">{{ $teacher->phone ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button @click="openEditModal({{ json_encode($teacher) }})"
                                            class="p-2 text-text-muted hover:text-primary hover:bg-info-light rounded-lg transition-all duration-200 cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลอาจารย์นี้?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-text-muted hover:text-error hover:bg-error-light rounded-lg transition-all duration-200 cursor-pointer">
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
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 bg-surface-hover rounded-full flex items-center justify-center">
                                            <svg class="w-7 h-7 text-text-disabled" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-text-muted font-medium text-sm">ไม่พบข้อมูลอาจารย์</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($teachers->hasPages())
                <div class="px-6 py-4 bg-surface-hover/50 border-t border-border">
                    {{ $teachers->links() }}
                </div>
            @endif
        </div>
    </main>

    <!-- Modal -->
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="isModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-surface rounded-2xl text-left overflow-hidden shadow-elevated transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full relative z-[101]">
                <form :action="isEditMode ? '{{ url('teachers') }}/' + teacherId : '{{ route('teachers.store') }}'" method="POST">
                    @csrf
                    <template x-if="isEditMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div class="px-6 md:px-8 pt-8 pb-6">
                        <h3 class="text-xl font-bold text-text mb-6" x-text="isEditMode ? 'แก้ไขข้อมูลอาจารย์' : 'เพิ่มอาจารย์ใหม่'">
                        </h3>

                        <div class="space-y-5">
                            <div>
                                <label class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2 block">รหัสอาจารย์
                                    <span class="text-error">*</span></label>
                                <input type="text" name="teacher_code" x-model="form.teacher_code" placeholder="เช่น T001" required
                                    class="w-full px-4 py-3 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 text-sm">
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2 block">คำนำหน้า</label>
                                    <input type="text" name="title_th" x-model="form.title_th" placeholder="นาย, นาง, ดร."
                                        class="w-full px-4 py-3 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 text-sm">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2 block">ชื่อ
                                        <span class="text-error">*</span></label>
                                    <input type="text" name="first_name_th" x-model="form.first_name_th" required
                                        class="w-full px-4 py-3 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 text-sm">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2 block">นามสกุล
                                        <span class="text-error">*</span></label>
                                    <input type="text" name="last_name_th" x-model="form.last_name_th" required
                                        class="w-full px-4 py-3 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2 block">ตำแหน่ง</label>
                                <input type="text" name="position" x-model="form.position" placeholder="เช่น อาจารย์ประจำสาขา"
                                    class="w-full px-4 py-3 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 text-sm">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2 block">อีเมล</label>
                                    <input type="email" name="email" x-model="form.email" placeholder="example@email.com"
                                        class="w-full px-4 py-3 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 text-sm">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2 block">เบอร์โทรศัพท์</label>
                                    <input type="text" name="phone" x-model="form.phone"
                                        class="w-full px-4 py-3 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all duration-200 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface-hover/50 px-6 md:px-8 py-5 flex flex-col sm:flex-row-reverse gap-3 border-t border-border">
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-md shadow-primary/20 cursor-pointer active:scale-95">
                            บันทึกข้อมูล
                        </button>
                        <button type="button" @click="isModalOpen = false"
                            class="w-full sm:w-auto px-6 py-2.5 bg-surface border border-border text-sm font-semibold text-text-secondary rounded-xl hover:bg-surface-hover transition-all duration-200 cursor-pointer">
                            ยกเลิก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Import Modal -->
    <div x-show="showImportModal" x-transition.opacity
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[110] flex items-center justify-center p-4"
        style="display: none;">
        
        <div x-show="showImportModal" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.away="showImportModal = false"
            class="bg-surface rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-border">
            
            <form action="{{ route('teachers.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-5 border-b border-border flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-info-light rounded-xl text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-text">นำเข้าข้อมูลอาจารย์</h3>
                            <p class="text-sm text-text-muted">อัปโหลดไฟล์ (.xlsx, .xls, .csv)</p>
                        </div>
                    </div>
                    <button type="button" @click="showImportModal = false" class="text-text-muted hover:text-text p-1.5 rounded-lg hover:bg-surface-hover">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="relative">
                        <input type="file" name="importFile" id="teacherImportFile" class="hidden" accept=".xlsx,.xls,.csv" required
                                x-on:change="fileName = $event.target.files[0] ? $event.target.files[0].name : null">
                        
                        <label for="teacherImportFile" 
                                class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-border rounded-2xl hover:bg-info-light/30 hover:border-primary/40 transition-all duration-200 cursor-pointer group bg-surface-hover/50">
                            
                            <div x-show="!fileName" class="flex flex-col items-center text-center p-6">
                                <div class="w-14 h-14 bg-surface shadow-sm border border-border rounded-xl flex items-center justify-center mb-4 text-primary">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-text">คลิกเพื่อเลือกไฟล์</h4>
                                <p class="text-xs text-text-disabled mt-2">.xlsx, .xls, .csv</p>
                            </div>

                            <div x-show="fileName" class="flex flex-col items-center w-full h-full justify-center p-6 bg-surface" style="display: none;">
                                <div class="w-full max-w-sm bg-surface-hover border border-border rounded-xl p-4 flex items-center">
                                    <div class="w-10 h-10 bg-surface rounded-lg flex items-center justify-center text-success mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-text truncate" x-text="fileName"></p>
                                        <span class="text-xs text-success font-medium">พร้อมนำเข้า</span>
                                    </div>
                                </div>
                                <p @click.stop="fileName = null; document.getElementById('teacherImportFile').value = '';" class="mt-3 text-xs text-error hover:underline cursor-pointer">เปลี่ยนไฟล์</p>
                            </div>
                        </label>
                    </div>

                    <div class="bg-warning-light border border-amber-200 rounded-xl p-4 flex gap-3 text-xs text-amber-800">
                        <svg class="w-5 h-5 shrink-0 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>กรุณาใช้ไฟล์แบบฟอร์มที่กำหนด หากรหัสอาจารย์ซ้ำ ระบบจะทำอัปเดตข้อมูลเป็นปัจจุบัน</p>
                    </div>
                </div>

                <div class="px-6 py-4 bg-surface-hover/50 border-t border-border flex justify-end gap-3">
                    <button type="button" @click="showImportModal = false; fileName = null;" class="px-5 py-2.5 text-text-secondary font-medium rounded-xl text-sm transition-all hover:bg-surface border border-transparent">
                        ยกเลิก
                    </button>
                    <button type="submit" x-show="fileName" class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl text-sm transition-all shadow-md shadow-primary/20">
                        ยืนยันการนำเข้า
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>
