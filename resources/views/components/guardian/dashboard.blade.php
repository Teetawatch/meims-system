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
    </style>

    <!-- Sidebar -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-guardian-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-6 md:p-8 lg:p-10 overflow-y-auto relative">
        <!-- Top Nav (Mobile Toggle & Notifications) -->
        <div class="flex justify-between items-center mb-6 lg:mb-8 animate-fade-in">
            <h2 class="text-xl font-bold text-slate-800 lg:hidden">MEIMS Guardian</h2>
            <div class="ml-auto flex items-center gap-4">
                <livewire:notification-dropdown />
                
                <div class="h-8 w-px bg-slate-200"></div>
                
                <div class="relative group">
                    <button class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        <span>บัญชีผู้ปกครอง</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform origin-top-right z-50">
                        <a href="{{ route('guardian.logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">ออกจากระบบ</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 mb-8 animate-fade-in">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-teal-600 flex items-center justify-center text-white text-2xl font-bold shadow-sm shrink-0">
                    {{ mb_substr($guardian->first_name_th, 0, 1) }}
                </div>
                <div class="text-center md:text-left flex-1">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">ระบบผู้ปกครอง</p>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800 leading-tight mb-2">
                        สวัสดี, {{ $guardian->title_th }}{{ $guardian->first_name_th }} {{ $guardian->last_name_th }}
                    </h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-50 text-teal-700 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $guardian->relationship ?? 'ผู้ปกครอง' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium">
                            ดูแลบุตรหลาน {{ $students->count() }} คน
                        </span>
                    </div>
                </div>
                <div class="hidden md:flex flex-col items-end text-right shrink-0">
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">วันที่</p>
                    <p class="text-lg font-bold text-slate-700">{{ now()->locale('th')->translatedFormat('d F') }}</p>
                    <p class="text-sm text-slate-400 font-medium">พ.ศ. {{ now()->year + 543 }}</p>
                </div>
            </div>
        </div>

        <!-- Children Cards -->
        <h2 class="text-lg font-bold text-slate-800 mb-4 animate-fade-in-1">ข้อมูลบุตรหลาน</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            @foreach($students as $index => $student)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-fade-in-{{ min($index + 1, 3) }}">
                    <!-- Student Header -->
                    <div class="p-6 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl overflow-hidden border-2 border-slate-200 shrink-0">
                                @if($student->photo_path)
                                    <img src="{{ asset('images/students/' . $student->photo_path) }}" alt="รูปภาพ" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-slate-700 flex items-center justify-center text-white text-xl font-bold">
                                        {{ mb_substr($student->first_name_th, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-800 text-lg truncate">{{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs font-medium text-slate-400">{{ $student->student_id }}</span>
                                    <span class="text-slate-200">•</span>
                                    <span class="text-xs font-medium text-blue-600">{{ $student->course->course_name_th ?? $student->course_name }}</span>
                                </div>
                            </div>
                            <a href="{{ route('guardian.student', $student->id) }}"
                                class="px-4 py-2 bg-teal-50 text-teal-700 text-sm font-semibold rounded-xl hover:bg-teal-100 transition-colors shrink-0">
                                ดูรายละเอียด
                            </a>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-3 divide-x divide-slate-100">
                        <!-- Conduct -->
                        <div class="p-5 text-center">
                            <p class="text-xs font-semibold text-slate-400 mb-1">ความประพฤติ</p>
                            @php
                                $conductScore = 100 + $student->conductScores->sum('score');
                            @endphp
                            <h4 class="text-xl font-bold {{ $conductScore >= 80 ? 'text-emerald-600' : ($conductScore >= 60 ? 'text-amber-600' : 'text-red-500') }}">
                                {{ $conductScore }}
                            </h4>
                            <div class="mt-2 h-1 bg-slate-100 rounded-full overflow-hidden mx-auto max-w-[60px]">
                                <div class="h-full rounded-full {{ $conductScore >= 80 ? 'bg-emerald-500' : ($conductScore >= 60 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ min($conductScore, 100) }}%"></div>
                            </div>
                        </div>
                        <!-- GPA -->
                        <div class="p-5 text-center">
                            <p class="text-xs font-semibold text-slate-400 mb-1">GPA ล่าสุด</p>
                            <h4 class="text-xl font-bold text-blue-600">
                                {{ number_format($student->gpa_y1_t2 ?? $student->gpa_y1_t1 ?? 0, 2) }}
                            </h4>
                            <p class="text-xs text-slate-300 mt-1">/ 4.00</p>
                        </div>
                        <!-- Batch -->
                        <div class="p-5 text-center">
                            <p class="text-xs font-semibold text-slate-400 mb-1">รุ่น</p>
                            <h4 class="text-xl font-bold text-slate-700">{{ $student->batch }}</h4>
                            <p class="text-xs text-slate-300 mt-1">ปี {{ $student->fiscal_year }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($students->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center animate-fade-in-1">
                <div class="w-16 h-16 rounded-xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-600 mb-1">ยังไม่มีข้อมูลบุตรหลาน</h3>
                <p class="text-sm text-slate-400">กรุณาติดต่อกองทะเบียนเพื่อเชื่อมโยงข้อมูลบุตรหลาน</p>
            </div>
        @endif
    </main>
</div>
