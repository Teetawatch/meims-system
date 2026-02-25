<x-layouts.student title="ระบบประเมินผล">
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes blob {
        0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        50%       { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
    }
    .animate-fade-in-up   { animation: fadeInUp .55s ease-out both; }
    .animate-fade-in-up-1 { animation: fadeInUp .55s ease-out .08s both; }
    .animate-fade-in-up-2 { animation: fadeInUp .55s ease-out .16s both; }
    .animate-fade-in-up-3 { animation: fadeInUp .55s ease-out .24s both; }
    .animate-fade-in-up-4 { animation: fadeInUp .55s ease-out .32s both; }
    .animate-blob         { animation: blob 8s ease-in-out infinite; }
    .animate-blob-delay   { animation: blob 8s ease-in-out 4s infinite; }
    .glass-card {
        background: rgba(255,255,255,.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    .eval-card {
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .eval-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 40px -10px rgba(99,102,241,.14);
    }
</style>

<div class="min-h-screen flex bg-gradient-to-br from-blue-50 via-indigo-50/30 to-violet-50/40 overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-6 md:p-10 overflow-y-auto">

        {{-- ── Hero ── --}}
        <div class="relative rounded-[2rem] overflow-hidden p-8 md:p-12 mb-8 animate-fade-in-up"
             style="background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 35%, #ede9fe 65%, #fce7f3 100%);">

            {{-- Decorative blobs --}}
            <div class="absolute top-[-20%] right-[-10%] w-72 h-72 bg-blue-300/25 animate-blob"
                 style="filter:blur(60px);"></div>
            <div class="absolute bottom-[-20%] left-[-5%] w-64 h-64 bg-violet-300/25 animate-blob-delay"
                 style="filter:blur(60px);"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                 style="background-image:radial-gradient(circle,#6366f1 1px,transparent 1px);background-size:24px 24px;"></div>

            <div class="relative z-10">
                <p class="text-xs font-bold text-violet-500/80 tracking-widest uppercase mb-2">Student Portal</p>
                <h1 class="text-3xl md:text-4xl font-black text-text tracking-tight mb-3">ระบบประเมินผล</h1>
                <p class="text-text-secondary text-sm font-medium max-w-xl leading-relaxed">
                    ประเมินผลอาจารย์ผู้สอนและเพื่อนร่วมรุ่น เพื่อพัฒนาคุณภาพการศึกษา
                </p>

                {{-- Status chips --}}
                <div class="mt-5 flex flex-wrap gap-2.5">
                    <span class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-xl text-sm font-semibold border border-white/60 shadow-sm
                        {{ $teacherEvaluationEnabled ? 'text-emerald-700' : 'text-text-muted' }}">
                        <span class="w-2 h-2 rounded-full {{ $teacherEvaluationEnabled ? 'bg-emerald-400 animate-pulse' : 'bg-slate-300' }}"></span>
                        ประเมินอาจารย์: {{ $teacherEvaluationEnabled ? 'เปิดแล้ว' : 'ยังไม่เปิด' }}
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-xl text-sm font-semibold border border-white/60 shadow-sm
                        {{ $peerEvaluationEnabled ? 'text-emerald-700' : 'text-text-muted' }}">
                        <span class="w-2 h-2 rounded-full {{ $peerEvaluationEnabled ? 'bg-emerald-400 animate-pulse' : 'bg-slate-300' }}"></span>
                        ประเมินเพื่อน: {{ $peerEvaluationEnabled ? 'เปิดแล้ว' : 'ยังไม่เปิด' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Toast --}}
        @if(session('success'))
            <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)"
                 class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3.5 rounded-2xl text-sm font-semibold shadow-sm">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)"
                 class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-2xl text-sm font-semibold shadow-sm">
                <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- ── 2-Column Grid ── --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

            {{-- ════════════════════════
                 Col 1 — ประเมินอาจารย์
                 ════════════════════════ --}}
            <section class="animate-fade-in-up-1">
                {{-- Section title --}}
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm
                        {{ $teacherEvaluationEnabled
                            ? 'bg-gradient-to-br from-blue-500 to-indigo-600 text-white'
                            : 'bg-white/60 border border-border text-text-disabled' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-text">ประเมินอาจารย์</h2>
                        <p class="text-xs text-text-disabled font-medium">รายวิชาในภาคการศึกษานี้</p>
                    </div>
                    {{-- Badge --}}
                    @if($teacherEvaluationEnabled)
                        <span class="ml-auto inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest bg-emerald-100 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> เปิดแล้ว
                        </span>
                    @else
                        <span class="ml-auto inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest bg-slate-100 text-slate-400 border border-slate-200 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span> ปิดอยู่
                        </span>
                    @endif
                </div>

                @if(!$teacherEvaluationEnabled)
                    {{-- Locked --}}
                    <div class="glass-card border border-white/60 rounded-3xl p-12 text-center flex flex-col items-center shadow-sm min-h-[220px] justify-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <p class="font-bold text-text">ยังไม่เปิดให้ประเมิน</p>
                        <p class="text-sm text-text-disabled mt-1">ผู้ดูแลระบบยังไม่เปิดระบบประเมินอาจารย์</p>
                    </div>

                @else
                    @php $hasTeachers = false; @endphp
                    <div class="space-y-3">
                        @foreach($subjects as $subject)
                            @foreach($subject->teachers as $teacher)
                                @php
                                    $hasTeachers = true;
                                    $done = in_array($subject->id . '_' . $teacher->id, $evaluatedTeachers);
                                @endphp
                                <div class="glass-card border border-white/60 rounded-2xl p-5 flex items-center gap-4 shadow-sm {{ $done ? '' : 'eval-card cursor-pointer' }}">
                                    {{-- Subject avatar --}}
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-sm shrink-0
                                        {{ $done
                                            ? 'bg-slate-100 text-slate-400'
                                            : 'bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-md shadow-indigo-300/40' }}">
                                        {{ strtoupper(substr($subject->subject_code, 0, 2)) }}
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">
                                        <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">{{ $subject->subject_code }}</span>
                                        <h3 class="font-bold text-text text-sm leading-snug truncate mt-0.5">{{ $subject->subject_name_th }}</h3>
                                        <p class="text-xs text-text-disabled font-medium mt-0.5">
                                            {{ $teacher->title_th ?? '' }}{{ $teacher->first_name_th }} {{ $teacher->last_name_th }}
                                        </p>
                                    </div>

                                    {{-- CTA --}}
                                    @if($done)
                                        <span class="shrink-0 inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            ประเมินแล้ว
                                        </span>
                                    @else
                                        <a href="{{ route('student.teacher-evaluation', [$subject->id, $teacher->id]) }}"
                                           class="shrink-0 inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors shadow-md shadow-indigo-500/20 active:scale-95">
                                            เริ่มประเมิน
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach

                        @if(!$hasTeachers)
                            <div class="glass-card border border-dashed border-border rounded-3xl p-12 text-center flex flex-col items-center shadow-sm">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl border border-dashed border-slate-200 flex items-center justify-center text-slate-300 mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                                <p class="font-bold text-text">ยังไม่มีรายการประเมิน</p>
                                <p class="text-sm text-text-disabled mt-1">ประเมินครบแล้ว หรือยังไม่มีวิชาในหลักสูตร</p>
                            </div>
                        @endif
                    </div>
                @endif
            </section>

            {{-- ════════════════════════
                 Col 2 — ประเมินเพื่อน
                 ════════════════════════ --}}
            <section class="animate-fade-in-up-2">
                {{-- Section title --}}
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm
                        {{ $peerEvaluationEnabled
                            ? 'bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white'
                            : 'bg-white/60 border border-border text-text-disabled' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-text">ประเมินเพื่อนร่วมรุ่น</h2>
                        <p class="text-xs text-text-disabled font-medium">พฤติกรรมและการมีส่วนร่วม</p>
                    </div>
                    @if($peerEvaluationEnabled)
                        <span class="ml-auto inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest bg-emerald-100 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> เปิดแล้ว
                        </span>
                    @else
                        <span class="ml-auto inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest bg-slate-100 text-slate-400 border border-slate-200 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span> ปิดอยู่
                        </span>
                    @endif
                </div>

                @if(!$peerEvaluationEnabled)
                    <div class="glass-card border border-white/60 rounded-3xl p-12 text-center flex flex-col items-center shadow-sm min-h-[220px] justify-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="font-bold text-text">Coming Soon</p>
                        <p class="text-sm text-text-disabled mt-1">ระบบประเมินเพื่อนยังไม่เปิดให้ใช้งาน</p>
                    </div>

                @else
                    <div class="space-y-3">
                        @forelse($classmates as $mate)
                            @php $donePeer = in_array($mate->id, $evaluatedPeers); @endphp
                            <div class="glass-card border border-white/60 rounded-2xl p-5 flex items-center gap-4 shadow-sm {{ $donePeer ? '' : 'eval-card cursor-pointer' }}">
                                {{-- Avatar --}}
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-base shrink-0
                                    {{ $donePeer
                                        ? 'bg-slate-100 text-slate-400'
                                        : 'bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white shadow-md shadow-violet-300/40' }}">
                                    {{ mb_substr($mate->first_name_th, 0, 1) }}
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-text text-sm leading-snug">{{ $mate->first_name_th }} {{ $mate->last_name_th }}</h3>
                                    <p class="text-[10px] font-bold text-violet-400 uppercase tracking-widest mt-0.5">{{ $mate->student_id }}</p>
                                </div>

                                @if($donePeer)
                                    <span class="shrink-0 inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        เรียบร้อย
                                    </span>
                                @else
                                    <a href="{{ route('student.peer-evaluation', $mate->id) }}"
                                       class="shrink-0 inline-flex items-center gap-1.5 bg-slate-800 hover:bg-violet-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors shadow-sm active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        ประเมิน
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div class="glass-card border border-dashed border-border rounded-3xl p-12 text-center flex flex-col items-center shadow-sm">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl border border-dashed border-slate-200 flex items-center justify-center text-slate-300 mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p class="font-bold text-text">ไม่พบรายชื่อเพื่อนในรุ่น</p>
                                <p class="text-sm text-text-disabled mt-1">ยังไม่มีนักเรียนอื่นในหลักสูตรของคุณ</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </section>

        </div>{{-- /grid --}}
    </main>
</div>
</x-layouts.student>
