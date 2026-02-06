<div class="min-h-screen flex bg-slate-50 overflow-hidden">

    <x-student-sidebar />

    <main class="flex-1 lg:ml-72 relative p-8 md:p-12 overflow-y-auto">
        <!-- Hero Section -->
        <div
            class="relative rounded-[3rem] overflow-hidden bg-slate-900 border border-slate-800 p-10 md:p-16 mb-10 shadow-2xl">
            <!-- Aurora Background -->
            <div class="absolute inset-0 opacity-40">
                <div
                    class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-500 rounded-full blur-[120px] animate-pulse">
                </div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-600 rounded-full blur-[120px] animate-pulse"
                    style="animation-delay: 2s;"></div>
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                <div
                    class="w-32 h-32 md:w-40 md:h-40 rounded-[2.5rem] overflow-hidden ring-8 ring-white/10 shadow-2xl group transition-all hover:scale-105">
                    @if($student->photo_path)
                        <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Profile"
                            class="w-full h-full object-cover">
                    @else
                        <div
                            class="w-full h-full bg-blue-600 flex items-center justify-center text-white text-5xl font-black">
                            {{ mb_substr($student->first_name_th, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="text-center md:text-left flex-1">
                    <h2 class="text-white text-3xl md:text-5xl font-black leading-tight mb-4 tracking-tight">
                        สวัสดีครับ, <br class="hidden md:block">คุณ{{ $student->first_name_th }}
                        {{ $student->last_name_th }} 👋
                    </h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        <span
                            class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-2xl text-white text-sm font-bold border border-white/10">
                            รหัส: {{ $student->student_id }}
                        </span>
                        <span
                            class="px-4 py-2 bg-blue-500/20 backdrop-blur-md rounded-2xl text-blue-300 text-sm font-bold border border-blue-500/20">
                            หลักสูตร: {{ $student->course->course_name_th ?? $student->course_name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Conduct Card -->
            <div
                class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col items-center text-center group hover:bg-orange-50/50 transition-all hover:-translate-y-2">
                <div
                    class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">ความประพฤติ</p>
                <h4 class="text-3xl font-black text-slate-800">{{ $student->total_conduct_score }}</h4>
            </div>

            <!-- GPA Card -->
            <div
                class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col items-center text-center group hover:bg-emerald-50/50 transition-all hover:-translate-y-2">
                <div
                    class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z">
                        </path>
                    </svg>
                </div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">GPA ล่าสุด</p>
                <h4 class="text-3xl font-black text-slate-800">
                    {{ number_format($student->gpa_y1_t2 ?? $student->gpa_y1_t1, 2) }}
                </h4>
            </div>

            <!-- Total Credits Card -->
            <div
                class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col items-center text-center group hover:bg-blue-50/50 transition-all hover:-translate-y-2">
                <div
                    class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">พุทธศักราช</p>
                <h4 class="text-3xl font-black text-slate-800">{{ $student->fiscal_year }}</h4>
            </div>

            <!-- Classmate Card -->
            <div
                class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col items-center text-center group hover:bg-pink-50/50 transition-all hover:-translate-y-2">
                <div
                    class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center text-pink-600 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">รุ่น / Batch</p>
                <h4 class="text-3xl font-black text-slate-800">{{ $student->batch }}</h4>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- My Classes -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden h-full">
                    <div class="p-8 pb-4 flex justify-between items-center bg-slate-50/50 border-b border-slate-100">
                        <h3 class="text-xl font-black text-slate-800">ตารางเรียนวันนี้</h3>
                        <a href="{{ route('student.timetable') }}"
                            class="text-blue-600 text-sm font-bold hover:underline">ดูทั้งหมด →</a>
                    </div>
                    <div class="p-4 space-y-4">
                        @php
                            // Mock classes for now since we don't have a specific today structure yet
                            // This would ideally fetch from a more complex Timetable model
                            $courses = $student->course ? $student->course->subjects->take(3) : [];
                        @endphp

                        @forelse($courses as $subject)
                            <div
                                class="flex items-center gap-6 p-6 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                                <div
                                    class="w-16 h-16 bg-blue-600 rounded-2xl flex flex-col items-center justify-center text-white font-black group-hover:scale-110 transition-transform">
                                    <span class="text-xs opacity-80">CODE</span>
                                    <span class="text-sm tracking-tight">{{ substr($subject->subject_code, 0, 3) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-bold text-slate-800">{{ $subject->subject_name_th }}</h5>
                                    <p class="text-xs text-slate-400 font-medium">ห้องเรียน 402 • 09:00 - 11:00 น.</p>
                                </div>
                                <div class="text-right">
                                    <div
                                        class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-widest">
                                        {{ $subject->credits }} Credits
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-slate-400">
                                <p>ไม่มีตารางเรียนในวันนี้</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Conduct -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 h-full flex flex-col">
                    <div class="p-8 pb-4 bg-slate-50/50 border-b border-slate-100">
                        <h3 class="text-xl font-black text-slate-800">ความประพฤติล่าสุด</h3>
                    </div>
                    <div class="p-6 flex-1 space-y-6 overflow-y-auto max-h-[400px]">
                        @forelse($student->conductScores()->latest()->take(5)->get() as $score)
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-2 h-2 rounded-full {{ $score->score > 0 ? 'bg-green-500' : 'bg-red-500' }} mt-2 ring-4 {{ $score->score > 0 ? 'ring-green-500/10' : 'ring-red-500/10' }}">
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h5 class="text-sm font-bold text-slate-800">{{ $score->description }}</h5>
                                        <span
                                            class="text-xs font-black {{ $score->score > 0 ? 'text-green-600' : 'text-red-500' }}">
                                            {{ $score->score > 0 ? '+' : '' }}{{ $score->score }}
                                        </span>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-medium uppercase mt-1">
                                        {{ $score->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center py-12 text-slate-400">
                                <p>ยังไม่มีประวัติความประพฤติ</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="p-6 border-t border-slate-50">
                        <a href="{{ route('student.conduct') }}"
                            class="block text-center py-3 bg-slate-50 text-slate-600 font-bold rounded-2xl hover:bg-slate-100 transition-colors">
                            ดูประวัติทั้งหมด
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Documents -->
        <div class="mt-8">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 pb-4 flex justify-between items-center bg-slate-50/50 border-b border-slate-100">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">เอกสารเผยแพร่ล่าสุด</h3>
                    <a href="{{ route('student.documents') }}"
                        class="text-indigo-600 text-sm font-bold hover:underline">คลังเอกสารทั้งหมด →</a>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($recentDocuments as $doc)
                        <div
                            class="flex items-center gap-4 p-4 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                            <div
                                class="w-12 h-12 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all shadow-sm shrink-0">
                                @if($doc->file_type == 'PDF')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h5
                                    class="text-sm font-bold text-slate-800 truncate group-hover:text-indigo-600 transition-colors">
                                    {{ $doc->title }}</h5>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-0.5">
                                    {{ $doc->file_size }}</p>
                            </div>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                class="p-2 text-slate-300 hover:text-slate-900 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-slate-400 font-medium">
                            ยังไม่มีเอกสารใหม่ในขณะนี้
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>