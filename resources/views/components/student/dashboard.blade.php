<div class="min-h-screen flex bg-slate-50 font-['Outfit','Anuphan']">

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out both; }
        .animate-fade-in-1 { animation: fadeIn 0.5s ease-out 0.08s both; }
        .animate-fade-in-2 { animation: fadeIn 0.5s ease-out 0.16s both; }
        .animate-fade-in-3 { animation: fadeIn 0.5s ease-out 0.24s both; }
        .animate-fade-in-4 { animation: fadeIn 0.5s ease-out 0.32s both; }
    </style>

    <!-- Sidebar -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-6 md:p-8 lg:p-10 overflow-y-auto relative">
        <!-- Top Nav (Mobile Toggle & Notifications) -->
        <div class="flex justify-between items-center mb-6 lg:mb-8 animate-fade-in">
            <h2 class="text-xl font-bold text-slate-800 lg:hidden">MEIMS Student</h2>
            <div class="ml-auto flex items-center gap-4">
                <livewire:notification-dropdown />
                
                <div class="h-8 w-px bg-slate-200"></div>
                
                <div class="relative group">
                    <button class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        <span>บัญชีผู้ใช้</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform origin-top-right z-50">
                        <a href="{{ route('student.logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">ออกจากระบบ</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Banner Slider -->
        @if($banners->count() > 0)
        <div class="mb-8 animate-fade-in" x-data="{ 
            activeSlide: 0, 
            slides: {{ $banners->count() }},
            next() { this.activeSlide = (this.activeSlide + 1) % this.slides },
            prev() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides },
            init() {
                setInterval(() => { this.next() }, 5000)
            }
        }">
            <div class="relative h-[200px] md:h-[350px] bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200">
                <!-- Slides -->
                @foreach($banners as $index => $banner)
                <div x-show="activeSlide === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform scale-105"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-700"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute inset-0"
                     style="display: none;">
                    <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover">
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent flex flex-col justify-end p-6 md:p-10">
                        <div class="max-w-2xl">
                            @if($banner->title)
                                <h2 class="text-white text-2xl md:text-4xl font-black mb-3 drop-shadow-lg leading-tight">{{ $banner->title }}</h2>
                            @endif
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" target="_blank" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-900 rounded-xl font-bold hover:bg-blue-50 transition-all transform hover:scale-105 active:scale-95 shadow-lg">
                                    รายละเอียดเพิ่มเติม
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Controls -->
                @if($banners->count() > 1)
                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-2xl hover:bg-white/20 transition-all group">
                    <svg class="w-6 h-6 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-2xl hover:bg-white/20 transition-all group">
                    <svg class="w-6 h-6 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- Indicators -->
                <div class="absolute bottom-6 left-6 flex gap-2.5">
                    @foreach($banners as $index => $banner)
                    <button @click="activeSlide = {{ $index }}" 
                            :class="activeSlide === {{ $index }} ? 'bg-white w-10' : 'bg-white/40 w-2.5'"
                            class="h-2.5 rounded-full transition-all duration-500"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Header Section -->

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 mb-8 animate-fade-in-1">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <!-- Profile Photo -->
                <div class="relative shrink-0">
                    <div class="w-24 h-24 md:w-28 md:h-28 rounded-2xl overflow-hidden border-2 border-slate-200 shadow-sm">
                        @if($student->photo_path)
                            <img src="{{ asset('images/students/' . $student->photo_path) }}" alt="รูปโปรไฟล์"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-700 text-white text-3xl md:text-4xl font-bold">
                                {{ mb_substr($student->first_name_th, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-[3px] border-white" title="ออนไลน์"></div>
                </div>

                <div class="text-center md:text-left flex-1">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">หน้าหลักนักเรียน</p>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800 leading-tight mb-3">
                        สวัสดี, {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}
                    </h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                            {{ $student->student_id }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ $student->course->course_name_th ?? $student->course_name }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium">
                            รุ่น {{ $student->batch }} • ปี {{ $student->fiscal_year }}
                        </span>
                    </div>
                </div>

                <!-- Date/Time -->
                <div class="hidden md:flex flex-col items-end text-right shrink-0">
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">วันที่</p>
                    <p class="text-lg font-bold text-slate-700">{{ now()->locale('th')->translatedFormat('d F') }}</p>
                    <p class="text-sm text-slate-400 font-medium">พ.ศ. {{ now()->year + 543 }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mb-8">
            <!-- Conduct Score -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200 animate-fade-in-1">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-400">/ 100</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mb-0.5">คะแนนความประพฤติ</p>
                <h4 class="text-2xl font-bold text-slate-800">{{ $student->total_conduct_score }}</h4>
                <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-amber-500 transition-all duration-700" style="width: {{ min(($student->total_conduct_score / 100) * 100, 100) }}%"></div>
                </div>
            </div>

            <!-- GPA -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200 animate-fade-in-2">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-400">/ 4.00</span>
                </div>
                <p class="text-xs font-semibold text-slate-500 mb-0.5">GPA ล่าสุด</p>
                <h4 class="text-2xl font-bold text-slate-800">{{ number_format($student->gpa_y1_t2 ?? $student->gpa_y1_t1, 2) }}</h4>
                <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-emerald-500 transition-all duration-700" style="width: {{ min((($student->gpa_y1_t2 ?? $student->gpa_y1_t1) / 4) * 100, 100) }}%"></div>
                </div>
            </div>

            <!-- Fiscal Year -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200 animate-fade-in-3">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-slate-500 mb-0.5">ปีการศึกษา</p>
                <h4 class="text-2xl font-bold text-slate-800">{{ $student->fiscal_year }}</h4>
                <p class="text-xs text-slate-400 mt-2 font-medium">พุทธศักราช</p>
            </div>

            <!-- Batch -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200 animate-fade-in-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-slate-500 mb-0.5">รุ่นที่</p>
                <h4 class="text-2xl font-bold text-slate-800">{{ $student->batch }}</h4>
                <p class="text-xs text-slate-400 mt-2 font-medium">Batch</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Today's Schedule -->
            <div class="lg:col-span-2 animate-fade-in-3">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full">
                    <div class="px-6 py-5 flex justify-between items-center border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800">ตารางเรียนวันนี้</h3>
                                <p class="text-xs text-slate-400 font-medium">{{ now()->locale('th')->translatedFormat('l d F Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('student.timetable') }}"
                            class="inline-flex items-center gap-1.5 text-blue-600 text-sm font-semibold hover:text-blue-700 transition-colors">
                            ดูทั้งหมด
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="p-4">
                        @php
                            $courses = $student->course ? $student->course->subjects->take(3) : [];
                        @endphp

                        @forelse($courses as $index => $subject)
                            <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-slate-50 transition-colors duration-150 border border-transparent hover:border-slate-100 {{ !$loop->last ? 'mb-1' : '' }}">
                                <!-- Subject Code Badge -->
                                <div class="w-12 h-12 rounded-xl flex flex-col items-center justify-center text-white font-bold shrink-0
                                    {{ ['bg-blue-600', 'bg-indigo-600', 'bg-slate-700'][$index % 3] }}">
                                    <span class="text-[9px] opacity-70 uppercase tracking-wider leading-none">Code</span>
                                    <span class="text-sm tracking-tight leading-none mt-0.5">{{ substr($subject->subject_code, 0, 3) }}</span>
                                </div>
                                <!-- Subject Info -->
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-semibold text-slate-800 text-sm truncate">{{ $subject->subject_name_th }}</h5>
                                    <p class="text-xs text-slate-400 font-medium mt-0.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $subject->subject_code }}
                                    </p>
                                </div>
                                <!-- Credits -->
                                <div class="shrink-0">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600">
                                        {{ $subject->credits }} หน่วยกิต
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="py-16 text-center">
                                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium text-sm">ไม่มีตารางเรียนในวันนี้</p>
                                <p class="text-slate-400 text-xs mt-1">ดูตารางเรียนทั้งหมดได้ที่หน้าตารางเรียน</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Conduct -->
            <div class="lg:col-span-1 animate-fade-in-4">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm h-full flex flex-col">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">ประวัติความประพฤติ</h3>
                        </div>
                    </div>
                    <div class="p-4 flex-1 space-y-1 overflow-y-auto max-h-[360px]">
                        @forelse($student->conductScores()->latest()->take(5)->get() as $score)
                            <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors duration-150">
                                <div class="mt-0.5 shrink-0">
                                    @if($score->score > 0)
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start gap-2">
                                        <h5 class="text-sm font-semibold text-slate-700 truncate">{{ $score->description }}</h5>
                                        <span class="text-xs font-bold shrink-0 px-2 py-0.5 rounded-md {{ $score->score > 0 ? 'text-emerald-700 bg-emerald-50' : 'text-red-600 bg-red-50' }}">
                                            {{ $score->score > 0 ? '+' : '' }}{{ $score->score }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 font-medium mt-1">
                                        {{ $score->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center py-12">
                                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium text-sm">ยังไม่มีประวัติความประพฤติ</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-slate-100">
                        <a href="{{ route('student.conduct') }}"
                            class="flex items-center justify-center gap-2 py-2.5 rounded-xl font-semibold text-sm text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors duration-150">
                            ดูประวัติทั้งหมด
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="mb-8 animate-fade-in-4">
            <h3 class="text-base font-bold text-slate-800 mb-4">เมนูลัด</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                <a href="{{ route('student.grades') }}" class="group bg-white rounded-2xl border border-slate-200 p-5 text-center shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 group-hover:text-blue-700">ผลการเรียน</p>
                </a>
                <a href="{{ route('student.timetable') }}" class="group bg-white rounded-2xl border border-slate-200 p-5 text-center shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-100 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 group-hover:text-indigo-700">ตารางเรียน</p>
                </a>
                <a href="{{ route('student.conduct') }}" class="group bg-white rounded-2xl border border-slate-200 p-5 text-center shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center mx-auto mb-3 group-hover:bg-amber-100 transition-colors">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 group-hover:text-amber-700">ความประพฤติ</p>
                </a>
                <a href="{{ route('student.surveys') }}" class="group bg-white rounded-2xl border border-slate-200 p-5 text-center shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center mx-auto mb-3 group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 group-hover:text-emerald-700">แบบสอบถาม</p>
                </a>
                <a href="{{ route('student.documents') }}" class="group bg-white rounded-2xl border border-slate-200 p-5 text-center shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-slate-200 transition-colors">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 group-hover:text-slate-900">เอกสาร</p>
                </a>
                <a href="{{ route('student.profile') }}" class="group bg-white rounded-2xl border border-slate-200 p-5 text-center shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-slate-200 transition-colors">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 group-hover:text-slate-900">โปรไฟล์</p>
                </a>
            </div>
        </div>

        <!-- Recent Documents -->
        <div class="animate-fade-in-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 flex justify-between items-center border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">เอกสารเผยแพร่ล่าสุด</h3>
                            <p class="text-xs text-slate-400 font-medium">เอกสารที่สถาบันเผยแพร่ให้นักเรียน</p>
                        </div>
                    </div>
                    <a href="{{ route('student.documents') }}"
                        class="inline-flex items-center gap-1.5 text-blue-600 text-sm font-semibold hover:text-blue-700 transition-colors">
                        ดูทั้งหมด
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @forelse($recentDocuments as $index => $doc)
                            <div class="group relative p-4 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/30 hover:shadow-sm transition-all duration-200">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 {{ ['bg-red-50', 'bg-blue-50', 'bg-indigo-50', 'bg-slate-100'][$index % 4] }}">
                                        @if($doc->file_type == 'PDF')
                                            <svg class="w-5 h-5 {{ ['text-red-500', 'text-blue-500', 'text-indigo-500', 'text-slate-500'][$index % 4] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 {{ ['text-red-500', 'text-blue-500', 'text-indigo-500', 'text-slate-500'][$index % 4] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-sm font-semibold text-slate-700 truncate group-hover:text-blue-700 transition-colors duration-150">
                                            {{ $doc->title }}</h5>
                                        <p class="text-xs text-slate-400 font-medium mt-1">{{ $doc->file_size }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                    class="absolute top-3 right-3 w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 hover:text-blue-600 hover:bg-blue-50 transition-all duration-150 opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center">
                                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium text-sm">ยังไม่มีเอกสารในขณะนี้</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>