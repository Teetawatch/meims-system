<x-layouts.student title="ข้อมูลส่วนตัว">
<div class="min-h-screen flex bg-surface-hover" x-data="{ activeTab: 'personal' }">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto relative">

        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-4 right-4 bg-green-500 text-white font-bold px-6 py-3 rounded-xl shadow-lg z-50">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-4 right-4 bg-red-500 text-white font-bold px-6 py-3 rounded-xl shadow-lg z-50">
            {{ session('error') }}
        </div>
        @endif

        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-text tracking-tight">ข้อมูลส่วนตัว</h1>
                <p class="text-text-muted font-medium mt-1">รายละเอียดข้อมูลส่วนตัวและประวัติการศึกษา</p>
            </div>
            
            <!-- Mobile Tabs -->
             <div class="md:hidden overflow-x-auto pb-2 -mx-4 px-4 scrollbar-hide">
                <div class="flex gap-2 min-w-max">
                    <button @click="activeTab = 'personal'" 
                        :class="activeTab === 'personal' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500'"
                        class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap shadow-sm transition-all">
                        ข้อมูลส่วนตัว
                    </button>
                    <button @click="activeTab = 'academic'" 
                        :class="activeTab === 'academic' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500'"
                        class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap shadow-sm transition-all">
                        การศึกษา
                    </button>
                    <button @click="activeTab = 'family'" 
                        :class="activeTab === 'family' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500'"
                        class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap shadow-sm transition-all">
                        ที่อยู่ & ครอบครัว
                    </button>
                    <button @click="activeTab = 'health'" 
                        :class="activeTab === 'health' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500'"
                        class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap shadow-sm transition-all">
                        สุขภาพ
                    </button>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left: Profile Card (Sticky) -->
            <div class="lg:col-span-4 lg:sticky lg:top-8 space-y-6">
                <!-- Profile Card -->
                <div class="bg-surface rounded-2xl p-8 shadow-xl shadow-slate-200/50 border border-border text-center relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-32 bg-[url('https://images.unsplash.com/photo-1579546929518-9e396f3cc809?auto=format&fit=crop&q=80')] bg-cover bg-center">
                        <div class="absolute inset-0 bg-gradient-to-b from-blue-600/80 to-blue-900/90 backdrop-blur-sm"></div>
                    </div>
                    
                    <div class="relative z-10 pt-12">
                        <div class="relative inline-block group/img mb-4">
                            <div class="w-32 h-32 md:w-36 md:h-36 rounded-[2rem] overflow-hidden ring-4 ring-white shadow-2xl mx-auto bg-surface-hover relative">
                                @if($student->photo_path)
                                    <img src="{{ asset('storage/' . $student->photo_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-110">
                                @else
                                    <div class="w-full h-full bg-primary flex items-center justify-center text-white text-5xl font-bold">
                                        {{ mb_substr($student->first_name_th, 0, 1) }}
                                    </div>
                                @endif
                                
                                <form x-ref="photoForm" action="{{ route('student.profile.updatePhoto') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label class="absolute inset-0 flex items-center justify-center bg-black/40 text-white opacity-0 group-hover/img:opacity-100 transition-all cursor-pointer">
                                        <input type="file" name="photo" x-ref="photoInput" @change="$refs.photoForm.submit()" class="hidden">
                                        <svg class="w-8 h-8 transform scale-75 group-hover/img:scale-100 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                    </label>
                                </form>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-text capitalize leading-tight mb-1">{{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</h3>
                        <p class="text-text-muted text-xs font-bold uppercase tracking-widest mb-4">{{ $student->title_en }} {{ $student->first_name_en }} {{ $student->last_name_en }}</p>

                         <div class="flex items-center justify-center gap-2 mb-6">
                            <span class="px-3 py-1 bg-info-light text-primary text-[10px] font-bold uppercase tracking-widest rounded-lg border border-blue-100">
                                ID: {{ $student->student_id }}
                            </span>
                             <span class="px-3 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold uppercase tracking-widest rounded-lg border border-purple-100">
                                รุ่นที่ {{ $student->batch }}
                            </span>
                        </div>

                        <!-- Quick Contact -->
                        <div class="bg-surface-hover rounded-2xl p-4 space-y-3 text-left">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-text-disabled shrink-0 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[10px] font-bold text-text-disabled uppercase tracking-widest">Email</p>
                                    <p class="text-xs font-bold text-text-secondary truncate" title="{{ $student->email }}">{{ $student->email }}</p>
                                </div>
                            </div>
                             <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-text-disabled shrink-0 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-text-disabled uppercase tracking-widest">Phone</p>
                                    <p class="text-xs font-bold text-text-secondary">{{ $student->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="bg-surface rounded-2xl p-6 shadow-sm border border-border flex items-center justify-between">
                     <div>
                        <p class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-1">สถานะปัจจุบัน</p>
                        <p class="text-sm font-bold text-emerald-600 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            กำลังศึกษาอยู่
                        </p>
                    </div>
                     <div class="text-right">
                        <p class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-1">GPA สะสม</p>
                        <p class="text-2xl font-bold text-text">{{ number_format(($student->gpa_y1_t1 + $student->gpa_y1_t2) / 2, 2) }}</p>
                    </div>
                </div>
            </div>

             <!-- Right: Tabs & Content -->
            <div class="lg:col-span-8">
                 <!-- Desktop Tabs -->
                <div class="hidden md:flex items-center gap-2 mb-8 bg-white p-1.5 rounded-2xl border border-border w-fit shadow-sm">
                    <button @click="activeTab = 'personal'" 
                        :class="activeTab === 'personal' ? 'bg-slate-900 text-white shadow-md' : 'text-text-muted hover:text-text-secondary hover:bg-slate-50'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        ข้อมูลส่วนตัว
                    </button>
                    <button @click="activeTab = 'academic'" 
                        :class="activeTab === 'academic' ? 'bg-slate-900 text-white shadow-md' : 'text-text-muted hover:text-text-secondary hover:bg-slate-50'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        การศึกษา
                    </button>
                    <button @click="activeTab = 'family'" 
                        :class="activeTab === 'family' ? 'bg-slate-900 text-white shadow-md' : 'text-text-muted hover:text-text-secondary hover:bg-slate-50'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        ที่อยู่ & ครอบครัว
                    </button>
                    <button @click="activeTab = 'health'" 
                        :class="activeTab === 'health' ? 'bg-slate-900 text-white shadow-md' : 'text-text-muted hover:text-text-secondary hover:bg-slate-50'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        สุขภาพ
                    </button>
                </div>

                <!-- Tab Contents -->
                <div class="space-y-6">
                    <!-- Personal Info Tab -->
                    <div x-show="activeTab === 'personal'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-surface rounded-2xl p-8 md:p-10 shadow-sm border border-border">
                        
                         <h3 class="text-xl font-bold text-text mb-8 flex items-center gap-3">
                             <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                             ข้อมูลทั่วไป
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                             <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">เลขประจำตัวประชาชน</label>
                                <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                    {{ $student->id_card_number ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">วันเดือนปีเกิด</label>
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                        {{ $student->birth_date?->format('d/m/Y') ?? '-' }}
                                    </div>
                                    <div class="px-4 py-4 bg-info-light text-primary rounded-2xl font-bold min-w-[5rem] text-center border border-blue-100">
                                        {{ $student->birth_date?->age ?? '-' }} ปี
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">สัญชาติ / เชื้อชาติ / ศาสนา</label>
                                <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                    {{ $student->nationality ?? '-' }} / {{ $student->race ?? '-' }} / {{ $student->religion ?? '-' }}
                                </div>
                            </div>
                             <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">จังหวัดเกิด</label>
                                <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                    {{ $student->birth_province ?? '-' }}
                                </div>
                            </div>
                             <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">เพศ</label>
                                <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                     @if($student->gender == 'Male') ชาย
                                    @elseif($student->gender == 'Female') หญิง
                                    @else {{ $student->gender ?? '-' }} @endif
                                </div>
                            </div>
                             <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">หมู่เลือด</label>
                                <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                    {{ $student->blood_type ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Info Tab -->
                    <div x-show="activeTab === 'academic'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-surface rounded-2xl p-8 md:p-10 shadow-sm border border-border" style="display: none;">
                        
                        <h3 class="text-xl font-bold text-text mb-8 flex items-center gap-3">
                             <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                            </div>
                             ข้อมูลการศึกษา
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                             <div class="md:col-span-2">
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">หลักสูตรที่ศึกษา</label>
                                <div class="p-5 bg-purple-50 rounded-2xl border border-purple-100 font-bold text-purple-900 text-lg">
                                    {{ $student->course_name ?? $student->course?->course_name_th ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">ระดับการศึกษา</label>
                                <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                    {{ $student->degree_level ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">ปีการศึกษา / รุ่น</label>
                                <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                    ปี {{ $student->fiscal_year }} / รุ่นที่ {{ $student->batch }}
                                </div>
                            </div>
                             <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">วันที่เข้าศึกษา</label>
                                <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                    {{ $student->enrollment_date?->format('d/m/Y') ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">เกรดเฉลี่ย (GPA)</label>
                                 <div class="flex gap-3">
                                    <div class="flex-1 p-3 bg-surface-hover rounded-2xl border border-border text-center">
                                        <span class="block text-[10px] text-text-disabled uppercase font-bold mb-1">เทอม 1</span>
                                        <span class="text-xl font-bold text-text">{{ $student->gpa_y1_t1 ?? '-' }}</span>
                                    </div>
                                    <div class="flex-1 p-3 bg-surface-hover rounded-2xl border border-border text-center">
                                        <span class="block text-[10px] text-text-disabled uppercase font-bold mb-1">เทอม 2</span>
                                        <span class="text-xl font-bold text-text">{{ $student->gpa_y1_t2 ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Tab -->
                    <div x-show="activeTab === 'family'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-surface rounded-2xl p-8 md:p-10 shadow-sm border border-border" style="display: none;">
                        
                        <h3 class="text-xl font-bold text-text mb-8 flex items-center gap-3">
                             <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                             ที่อยู่และครอบครัว
                        </h3>

                        <div class="space-y-8">
                            <div>
                                <h4 class="text-sm font-bold text-text mb-4 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                    ที่อยู่ปัจจุบัน
                                </h4>
                                <div class="bg-surface-hover p-6 rounded-3xl border border-border">
                                    <p class="text-text-secondary font-medium leading-relaxed text-lg">
                                        {{ $student->current_address ?? '-' }} 
                                        <br class="md:hidden">
                                        ต.{{ $student->subdistrict ?? '-' }} อ.{{ $student->district ?? '-' }} 
                                        <br class="md:hidden">
                                        จ.{{ $student->province ?? '-' }} {{ $student->zip_code ?? '-' }}
                                    </p>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                         <span class="px-3 py-1 bg-white text-text-muted text-xs font-bold rounded-lg border border-border">
                                            สถานะ: {{ $student->housing_status ?? '-' }}
                                        </span>
                                         <span class="px-3 py-1 bg-white text-text-muted text-xs font-bold rounded-lg border border-border">
                                            ประเภท: {{ $student->residence_type ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-50">
                                    <h4 class="text-sm font-bold text-blue-800 mb-4">ข้อมูลบิดา</h4>
                                    <p class="text-lg font-bold text-text mb-1">{{ $student->father_name ?? '-' }}</p>
                                    <p class="text-sm text-text-muted mb-3">{{ $student->father_occupation ?? '-' }} (อายุ {{ $student->father_age ?? '-' }})</p>
                                    <p class="text-xs font-bold text-primary bg-blue-100 px-3 py-1 rounded-lg inline-block">
                                        รายได้: {{ number_format($student->father_income ?? 0) }} บ./เดือน
                                    </p>
                                </div>
                                <div class="bg-pink-50/50 p-6 rounded-3xl border border-pink-50">
                                    <h4 class="text-sm font-bold text-pink-800 mb-4">ข้อมูลมารดา</h4>
                                    <p class="text-lg font-bold text-text mb-1">{{ $student->mother_name ?? '-' }}</p>
                                    <p class="text-sm text-text-muted mb-3">{{ $student->mother_occupation ?? '-' }} (อายุ {{ $student->mother_age ?? '-' }})</p>
                                    <p class="text-xs font-bold text-pink-600 bg-pink-100 px-3 py-1 rounded-lg inline-block">
                                        รายได้: {{ number_format($student->mother_income ?? 0) }} บ./เดือน
                                    </p>
                                </div>
                            </div>
                             <div class="p-6 bg-surface-hover rounded-3xl border border-border flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-1 block">สถานะภาพครอบครัว</label>
                                    <p class="text-lg font-bold text-text-secondary">{{ $student->parents_marital_status ?? '-' }}</p>
                                </div>
                                 <div class="text-right">
                                    <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-1 block">รายได้ครอบครัวรวม</label>
                                    <p class="text-2xl font-bold text-text">{{ number_format($student->total_family_income ?? 0) }} <span class="text-sm font-medium text-text-disabled">บาท/เดือน</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                     <!-- Health Tab -->
                    <div x-show="activeTab === 'health'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-surface rounded-2xl p-8 md:p-10 shadow-sm border border-border" style="display: none;">
                        
                        <h3 class="text-xl font-bold text-text mb-8 flex items-center gap-3">
                             <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center text-pink-600">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                             ข้อมูลสุขภาพ
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="bg-indigo-50 rounded-3xl p-8 text-center border border-indigo-100">
                                <h4 class="text-indigo-900 font-bold mb-6">สัดส่วนร่างกาย</h4>
                                <div class="flex items-center justify-center gap-8">
                                    <div>
                                        <p class="text-4xl font-bold text-indigo-600 mb-1">{{ $student->weight ?? '-' }}</p>
                                        <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest">น้ำหนัก (กก.)</p>
                                    </div>
                                    <div class="w-px h-12 bg-indigo-200"></div>
                                    <div>
                                        <p class="text-4xl font-bold text-indigo-600 mb-1">{{ $student->height ?? '-' }}</p>
                                        <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest">ส่วนสูง (ซม.)</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">โรคประจำตัว</label>
                                    <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                        {{ $student->chronic_diseases ?? 'ไม่มี' }}
                                    </div>
                                </div>
                                 <div class="relative overflow-hidden group">
                                    <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">ประวัติการแพ้ยา/อาหาร</label>
                                    <div class="p-4 bg-error-light rounded-2xl border border-red-100 font-bold text-error relative z-10">
                                        {{ $student->allergies ?? 'ไม่มี' }}
                                    </div>
                                    @if($student->allergies)
                                        <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-red-100 rounded-full opacity-50 blur-xl"></div>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-2 block">ความพิการ</label>
                                    <div class="p-4 bg-surface-hover rounded-2xl border border-border font-bold text-text-secondary">
                                        {{ $student->disabilities ?? 'ไม่มี' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>
</x-layouts.student>
