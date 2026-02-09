<div class="min-h-screen flex bg-gradient-to-br from-blue-50 via-indigo-50/30 to-violet-50/40 overflow-hidden">

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes blob {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out 2s infinite; }
        .animate-blob { animation: blob 8s ease-in-out infinite; }
        .animate-blob-delay { animation: blob 8s ease-in-out 4s infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out both; }
        .animate-fade-in-up-1 { animation: fadeInUp 0.6s ease-out 0.1s both; }
        .animate-fade-in-up-2 { animation: fadeInUp 0.6s ease-out 0.2s both; }
        .animate-fade-in-up-3 { animation: fadeInUp 0.6s ease-out 0.3s both; }
        .animate-fade-in-up-4 { animation: fadeInUp 0.6s ease-out 0.4s both; }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .glass-card-strong {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
        }
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .shimmer-border {
            background: linear-gradient(90deg, transparent, rgba(139, 92, 246, 0.1), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.15) rotate(-5deg);
        }
        .stat-card:hover .stat-value {
            transform: scale(1.05);
        }
    </style>

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 relative p-6 md:p-10 overflow-y-auto">

        <!-- Hero Section -->
        <div class="relative rounded-[2rem] overflow-hidden p-8 md:p-12 mb-8 animate-fade-in-up"
             style="background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 30%, #ede9fe 60%, #fce7f3 100%);">

            <!-- Decorative Blobs -->
            <div class="absolute top-[-20%] right-[-10%] w-72 h-72 bg-blue-300/30 animate-blob" style="filter: blur(60px);"></div>
            <div class="absolute bottom-[-20%] left-[-5%] w-64 h-64 bg-violet-300/30 animate-blob-delay" style="filter: blur(60px);"></div>
            <div class="absolute top-[30%] left-[40%] w-48 h-48 bg-pink-200/20 animate-blob" style="filter: blur(50px); animation-delay: 2s;"></div>

            <!-- Subtle Grid Pattern -->
            <div class="absolute inset-0 opacity-[0.03]"
                 style="background-image: radial-gradient(circle, #6366f1 1px, transparent 1px); background-size: 24px 24px;"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                <!-- Profile Photo -->
                <div class="relative group cursor-pointer">
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-blue-400 via-violet-400 to-pink-400 rounded-[2rem] opacity-60 group-hover:opacity-100 blur-sm transition-all duration-500"></div>
                    <div class="relative w-28 h-28 md:w-36 md:h-36 rounded-[1.8rem] overflow-hidden ring-4 ring-white shadow-xl transition-transform duration-500 group-hover:scale-[1.03]">
                        @if($student->photo_path)
                            <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Profile"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white text-4xl md:text-5xl font-black"
                                 style="background: linear-gradient(135deg, #3b82f6, #8b5cf6);">
                                {{ mb_substr($student->first_name_th, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <!-- Online Indicator -->
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-400 rounded-full border-[3px] border-white shadow-lg"></div>
                </div>

                <div class="text-center md:text-left flex-1">
                    <p class="text-sm font-bold text-violet-500/80 tracking-wide mb-1 uppercase">Student Dashboard</p>
                    <h2 class="text-slate-800 text-3xl md:text-4xl lg:text-5xl font-black leading-tight mb-4 tracking-tight">
                        สวัสดีครับ, <br class="hidden md:block"><span class="gradient-text">คุณ{{ $student->first_name_th }} {{ $student->last_name_th }}</span>
                    </h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2.5">
                        <span class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-xl text-slate-700 text-sm font-bold border border-white/60 shadow-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                            {{ $student->student_id }}
                        </span>
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border shadow-sm"
                              style="background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(139,92,246,0.08)); border-color: rgba(139,92,246,0.15); color: #6d28d9;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ $student->course->course_name_th ?? $student->course_name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mb-8">
            <!-- Conduct Card -->
            <div class="stat-card glass-card rounded-2xl p-6 border border-white/60 shadow-sm hover:shadow-lg hover:shadow-orange-100/50 transition-all duration-300 hover:-translate-y-1.5 cursor-pointer group animate-fade-in-up-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm"
                         style="background: linear-gradient(135deg, #fed7aa, #fdba74); color: #c2410c;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-slate-500 text-xs font-semibold mb-1">ความประพฤติ</p>
                <h4 class="stat-value text-2xl md:text-3xl font-black text-slate-800 transition-transform duration-300">{{ $student->total_conduct_score }}</h4>
                <div class="mt-2 h-1.5 bg-orange-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-1000" style="width: {{ min(($student->total_conduct_score / 100) * 100, 100) }}%; background: linear-gradient(90deg, #fb923c, #f97316);"></div>
                </div>
            </div>

            <!-- GPA Card -->
            <div class="stat-card glass-card rounded-2xl p-6 border border-white/60 shadow-sm hover:shadow-lg hover:shadow-emerald-100/50 transition-all duration-300 hover:-translate-y-1.5 cursor-pointer group animate-fade-in-up-2">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm"
                         style="background: linear-gradient(135deg, #a7f3d0, #6ee7b7); color: #047857;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z">
                            </path>
                        </svg>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-slate-500 text-xs font-semibold mb-1">GPA ล่าสุด</p>
                <h4 class="stat-value text-2xl md:text-3xl font-black text-slate-800 transition-transform duration-300">
                    {{ number_format($student->gpa_y1_t2 ?? $student->gpa_y1_t1, 2) }}
                </h4>
                <div class="mt-2 h-1.5 bg-emerald-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-1000" style="width: {{ min((($student->gpa_y1_t2 ?? $student->gpa_y1_t1) / 4) * 100, 100) }}%; background: linear-gradient(90deg, #34d399, #10b981);"></div>
                </div>
            </div>

            <!-- Fiscal Year Card -->
            <div class="stat-card glass-card rounded-2xl p-6 border border-white/60 shadow-sm hover:shadow-lg hover:shadow-blue-100/50 transition-all duration-300 hover:-translate-y-1.5 cursor-pointer group animate-fade-in-up-3">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm"
                         style="background: linear-gradient(135deg, #bfdbfe, #93c5fd); color: #1d4ed8;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-slate-500 text-xs font-semibold mb-1">พุทธศักราช</p>
                <h4 class="stat-value text-2xl md:text-3xl font-black text-slate-800 transition-transform duration-300">{{ $student->fiscal_year }}</h4>
                <div class="mt-2 flex gap-1">
                    <div class="h-1.5 flex-1 rounded-full" style="background: linear-gradient(90deg, #60a5fa, #3b82f6);"></div>
                    <div class="h-1.5 flex-1 rounded-full bg-blue-100"></div>
                </div>
            </div>

            <!-- Batch Card -->
            <div class="stat-card glass-card rounded-2xl p-6 border border-white/60 shadow-sm hover:shadow-lg hover:shadow-violet-100/50 transition-all duration-300 hover:-translate-y-1.5 cursor-pointer group animate-fade-in-up-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm"
                         style="background: linear-gradient(135deg, #ddd6fe, #c4b5fd); color: #6d28d9;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-slate-500 text-xs font-semibold mb-1">รุ่น / Batch</p>
                <h4 class="stat-value text-2xl md:text-3xl font-black text-slate-800 transition-transform duration-300">{{ $student->batch }}</h4>
                <div class="mt-2 flex gap-1">
                    <div class="h-1.5 w-8 rounded-full" style="background: linear-gradient(90deg, #a78bfa, #8b5cf6);"></div>
                    <div class="h-1.5 w-5 rounded-full bg-violet-200"></div>
                    <div class="h-1.5 w-3 rounded-full bg-violet-100"></div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- My Classes -->
            <div class="lg:col-span-2 animate-fade-in-up-3">
                <div class="glass-card-strong rounded-2xl border border-white/60 shadow-sm overflow-hidden h-full">
                    <div class="p-6 pb-4 flex justify-between items-center border-b border-slate-100/60">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shadow-sm"
                                 style="background: linear-gradient(135deg, #bfdbfe, #93c5fd); color: #1d4ed8;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-black text-slate-800">ตารางเรียนวันนี้</h3>
                        </div>
                        <a href="{{ route('student.timetable') }}"
                            class="inline-flex items-center gap-1.5 text-blue-600 text-sm font-bold hover:text-blue-700 transition-colors cursor-pointer group/link">
                            ดูทั้งหมด
                            <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="p-4 space-y-2">
                        @php
                            // Mock classes for now since we don't have a specific today structure yet
                            // This would ideally fetch from a more complex Timetable model
                            $courses = $student->course ? $student->course->subjects->take(3) : [];
                        @endphp

                        @forelse($courses as $index => $subject)
                            <div class="flex items-center gap-5 p-4 rounded-xl hover:bg-white/60 transition-all duration-200 border border-transparent hover:border-slate-100/80 hover:shadow-sm group cursor-pointer">
                                <div class="w-14 h-14 rounded-xl flex flex-col items-center justify-center text-white font-black group-hover:scale-105 transition-transform duration-200 shadow-sm shrink-0"
                                     style="background: linear-gradient(135deg, {{ ['#3b82f6, #2563eb', '#8b5cf6, #7c3aed', '#ec4899, #db2777'][$index % 3] }});">
                                    <span class="text-[9px] opacity-70 uppercase tracking-wider">Code</span>
                                    <span class="text-sm tracking-tight leading-none">{{ substr($subject->subject_code, 0, 3) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-bold text-slate-800 text-sm truncate">{{ $subject->subject_name_th }}</h5>
                                    <p class="text-xs text-slate-400 font-medium mt-0.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        ห้องเรียน 402 • 09:00 - 11:00 น.
                                    </p>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-bold border"
                                          style="background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(139,92,246,0.05)); border-color: rgba(139,92,246,0.12); color: #6d28d9;">
                                        {{ $subject->credits }} หน่วยกิต
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="py-16 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #ede9fe, #ddd6fe);">
                                    <svg class="w-8 h-8 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-medium text-sm">ไม่มีตารางเรียนในวันนี้</p>
                                <p class="text-slate-300 text-xs mt-1">พักผ่อนให้เต็มที่นะ</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Conduct -->
            <div class="lg:col-span-1 animate-fade-in-up-4">
                <div class="glass-card-strong rounded-2xl border border-white/60 shadow-sm h-full flex flex-col">
                    <div class="p-6 pb-4 border-b border-slate-100/60">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shadow-sm"
                                 style="background: linear-gradient(135deg, #fed7aa, #fdba74); color: #c2410c;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-black text-slate-800">ความประพฤติล่าสุด</h3>
                        </div>
                    </div>
                    <div class="p-5 flex-1 space-y-4 overflow-y-auto max-h-[380px]">
                        @forelse($student->conductScores()->latest()->take(5)->get() as $score)
                            <div class="flex items-start gap-3.5 p-3 rounded-xl hover:bg-white/50 transition-all duration-200 cursor-pointer">
                                <div class="mt-0.5 shrink-0">
                                    @if($score->score > 0)
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0);">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #fee2e2, #fecaca);">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start gap-2">
                                        <h5 class="text-sm font-bold text-slate-700 truncate">{{ $score->description }}</h5>
                                        <span class="text-xs font-black shrink-0 px-2 py-0.5 rounded-md {{ $score->score > 0 ? 'text-emerald-700 bg-emerald-50' : 'text-red-600 bg-red-50' }}">
                                            {{ $score->score > 0 ? '+' : '' }}{{ $score->score }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 font-medium mt-1">
                                        {{ $score->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center py-12">
                                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                                    <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-medium text-sm">ยังไม่มีประวัติความประพฤติ</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-slate-100/60">
                        <a href="{{ route('student.conduct') }}"
                            class="flex items-center justify-center gap-2 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 cursor-pointer text-violet-600 hover:text-white hover:shadow-md"
                            style="background: linear-gradient(135deg, rgba(139,92,246,0.08), rgba(99,102,241,0.08));"
                            onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #6366f1)'"
                            onmouseout="this.style.background='linear-gradient(135deg, rgba(139,92,246,0.08), rgba(99,102,241,0.08))'; this.style.color='#7c3aed'"
                        >
                            ดูประวัติทั้งหมด
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Documents -->
        <div class="animate-fade-in-up-4">
            <div class="glass-card-strong rounded-2xl border border-white/60 shadow-sm overflow-hidden">
                <div class="p-6 pb-4 flex justify-between items-center border-b border-slate-100/60">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center shadow-sm"
                             style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe); color: #4338ca;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-slate-800">เอกสารเผยแพร่ล่าสุด</h3>
                    </div>
                    <a href="{{ route('student.documents') }}"
                        class="inline-flex items-center gap-1.5 text-indigo-600 text-sm font-bold hover:text-indigo-700 transition-colors cursor-pointer group/link">
                        คลังเอกสารทั้งหมด
                        <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse($recentDocuments as $index => $doc)
                        <div class="group relative p-4 rounded-xl border border-slate-100/60 hover:border-indigo-200/60 hover:bg-white/60 hover:shadow-md hover:shadow-indigo-50/50 transition-all duration-300 cursor-pointer">
                            <div class="flex items-start gap-3.5">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300 shadow-sm"
                                     style="background: linear-gradient(135deg, {{ ['#dbeafe, #bfdbfe', '#e0e7ff, #c7d2fe', '#ede9fe, #ddd6fe', '#fce7f3, #fbcfe8'][$index % 4] }});">
                                    @if($doc->file_type == 'PDF')
                                        <svg class="w-5 h-5 {{ ['text-blue-600', 'text-indigo-600', 'text-violet-600', 'text-pink-600'][$index % 4] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 {{ ['text-blue-600', 'text-indigo-600', 'text-violet-600', 'text-pink-600'][$index % 4] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-sm font-bold text-slate-700 truncate group-hover:text-indigo-600 transition-colors duration-200">
                                        {{ $doc->title }}</h5>
                                    <p class="text-[11px] text-slate-400 font-semibold mt-1">
                                        {{ $doc->file_size }}</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                class="absolute top-3 right-3 w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 opacity-0 group-hover:opacity-100 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe);">
                                <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-slate-400 font-medium text-sm">ยังไม่มีเอกสารใหม่ในขณะนี้</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>