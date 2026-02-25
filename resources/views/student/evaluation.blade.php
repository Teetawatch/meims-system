<x-layouts.student title="ระบบประเมินผล">
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0);    }
    }
    @keyframes pulse-soft {
        0%,100%{ opacity:1; }
        50%    { opacity:.6; }
    }
    .anim-item { animation: fadeInUp .45s ease both; }
    .anim-item:nth-child(1){ animation-delay:.05s }
    .anim-item:nth-child(2){ animation-delay:.12s }
    .anim-item:nth-child(3){ animation-delay:.19s }
    .anim-item:nth-child(4){ animation-delay:.26s }
    .anim-item:nth-child(5){ animation-delay:.33s }
    .anim-item:nth-child(6){ animation-delay:.40s }
    .card-hover{ transition: transform .2s ease, box-shadow .2s ease; }
    .card-hover:hover{ transform: translateY(-3px); box-shadow: 0 20px 40px -10px rgba(99,102,241,.15); }
    .status-badge { display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:700; letter-spacing:.06em; padding:4px 12px; border-radius:99px; text-transform:uppercase; }
</style>

<div class="min-h-screen flex bg-surface-hover font-body">

    {{-- Sidebar --}}
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 overflow-y-auto">

        {{-- ── Hero Header ── --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 px-8 pt-12 pb-20 md:px-14">
            {{-- Decorative blobs --}}
            <div class="absolute -top-16 -right-16 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-900/30 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl">
                <p class="text-indigo-200 text-sm font-semibold uppercase tracking-widest mb-3">Student Portal</p>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-3">ระบบประเมินผล</h1>
                <p class="text-indigo-200/80 text-base font-medium max-w-xl leading-relaxed">
                    ประเมินอาจารย์ผู้สอนและเพื่อนร่วมรุ่น เพื่อการพัฒนาคุณภาพการเรียนการสอน
                </p>

                {{-- Summary chips --}}
                <div class="mt-6 flex flex-wrap gap-3">
                    {{-- Teacher Eval Status --}}
                    @if($teacherEvaluationEnabled)
                        <div class="flex items-center gap-2 bg-white/15 backdrop-blur-sm rounded-full px-4 py-2 text-white text-sm font-semibold border border-white/20">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            ประเมินอาจารย์: เปิดแล้ว
                        </div>
                    @else
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 text-white/60 text-sm font-semibold border border-white/10">
                            <span class="w-2 h-2 bg-white/40 rounded-full"></span>
                            ประเมินอาจารย์: ยังไม่เปิด
                        </div>
                    @endif

                    {{-- Peer Eval Status --}}
                    @if($peerEvaluationEnabled)
                        <div class="flex items-center gap-2 bg-white/15 backdrop-blur-sm rounded-full px-4 py-2 text-white text-sm font-semibold border border-white/20">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            ประเมินเพื่อน: เปิดแล้ว
                        </div>
                    @else
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 text-white/60 text-sm font-semibold border border-white/10">
                            <span class="w-2 h-2 bg-white/40 rounded-full"></span>
                            ประเมินเพื่อน: ยังไม่เปิด
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Content ── --}}
        <div class="max-w-6xl mx-auto px-6 md:px-10 -mt-10 pb-16">

            {{-- Toast Messages --}}
            @if(session('success'))
                <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)"
                     class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3.5 rounded-2xl text-sm font-semibold shadow-sm">
                    <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)"
                     class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-2xl text-sm font-semibold shadow-sm">
                    <svg class="w-5 h-5 shrink-0 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

                {{-- ════════════════════════════
                     SECTION 1 — ประเมินอาจารย์
                     ════════════════════════════ --}}
                <section>
                    {{-- Section Header --}}
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg
                            {{ $teacherEvaluationEnabled ? 'bg-gradient-to-br from-indigo-500 to-violet-600 text-white' : 'bg-surface text-text-disabled border border-border' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-text tracking-tight">ประเมินอาจารย์</h2>
                            <p class="text-sm text-text-disabled font-medium mt-0.5">รายวิชาในภาคการศึกษานี้</p>
                        </div>
                        @if($teacherEvaluationEnabled)
                            <span class="status-badge bg-emerald-50 text-emerald-600 border border-emerald-100 ml-auto">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> เปิดแล้ว
                            </span>
                        @else
                            <span class="status-badge bg-slate-100 text-slate-400 ml-auto">
                                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span> ปิดอยู่
                            </span>
                        @endif
                    </div>

                    @if(!$teacherEvaluationEnabled)
                        {{-- Locked State --}}
                        <div class="bg-white border border-border rounded-3xl p-10 text-center flex flex-col items-center justify-center min-h-[260px]">
                            <div class="w-16 h-16 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <p class="text-text font-black text-lg">ยังไม่เปิดให้ประเมิน</p>
                            <p class="text-text-disabled text-sm mt-1 max-w-xs">ผู้ดูแลระบบยังไม่เปิดการประเมินอาจารย์ในขณะนี้</p>
                        </div>

                    @else
                        {{-- Subject List --}}
                        @php $hasTeachers = false; @endphp
                        <div class="space-y-3">
                            @foreach($subjects as $subject)
                                @foreach($subject->teachers as $teacher)
                                    @php
                                        $hasTeachers = true;
                                        $done = in_array($subject->id . '_' . $teacher->id, $evaluatedTeachers);
                                    @endphp
                                    <div class="anim-item bg-white rounded-3xl border border-border p-5 flex items-center gap-4 cursor-pointer {{ $done ? '' : 'card-hover' }} relative overflow-hidden group">
                                        {{-- Glow on hover --}}
                                        @unless($done)
                                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-50/60 to-violet-50/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-3xl"></div>
                                        @endunless

                                        {{-- Subject Icon --}}
                                        <div class="w-12 h-12 rounded-2xl {{ $done ? 'bg-slate-100 text-slate-400' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center font-black text-sm shrink-0 z-10">
                                            {{ strtoupper(substr($subject->subject_code, 0, 2)) }}
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-1 min-w-0 z-10">
                                            <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-0.5">{{ $subject->subject_code }}</div>
                                            <h3 class="font-bold text-text text-sm leading-snug truncate">{{ $subject->subject_name_th }}</h3>
                                            <p class="text-xs text-text-disabled font-medium mt-0.5">
                                                <span class="inline-block mr-1">👤</span>อ.{{ $teacher->first_name_th }} {{ $teacher->last_name_th }}
                                            </p>
                                        </div>

                                        {{-- Action / Status --}}
                                        <div class="z-10 shrink-0">
                                            @if($done)
                                                <span class="flex items-center gap-1.5 text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    ประเมินแล้ว
                                                </span>
                                            @else
                                                <a href="{{ route('student.teacher-evaluation', [$subject->id, $teacher->id]) }}"
                                                   class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors cursor-pointer shadow-md shadow-indigo-500/20 active:scale-95">
                                                    เริ่มประเมิน
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach

                            @if(!$hasTeachers)
                                <div class="bg-white border border-dashed border-border rounded-3xl p-10 text-center flex flex-col items-center">
                                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4 border border-dashed border-slate-200">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                    </div>
                                    <p class="font-black text-text">ยังไม่มีรายการประเมิน</p>
                                    <p class="text-sm text-text-disabled mt-1">ประเมินครบแล้ว หรือยังไม่มีรายวิชาในหลักสูตร</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </section>

                {{-- ════════════════════════════
                     SECTION 2 — ประเมินเพื่อน
                     ════════════════════════════ --}}
                <section>
                    {{-- Section Header --}}
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg
                            {{ $peerEvaluationEnabled ? 'bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white' : 'bg-surface text-text-disabled border border-border' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-text tracking-tight">ประเมินเพื่อนร่วมรุ่น</h2>
                            <p class="text-sm text-text-disabled font-medium mt-0.5">ประเมินพฤติกรรมและการมีส่วนร่วม</p>
                        </div>
                        @if($peerEvaluationEnabled)
                            <span class="status-badge bg-emerald-50 text-emerald-600 border border-emerald-100 ml-auto">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> เปิดแล้ว
                            </span>
                        @else
                            <span class="status-badge bg-slate-100 text-slate-400 ml-auto">
                                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span> ปิดอยู่
                            </span>
                        @endif
                    </div>

                    @if(!$peerEvaluationEnabled)
                        <div class="bg-white border border-border rounded-3xl p-10 text-center flex flex-col items-center justify-center min-h-[260px]">
                            <div class="w-16 h-16 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-text font-black text-lg">Coming Soon</p>
                            <p class="text-text-disabled text-sm mt-1">ระบบประเมินเพื่อนยังไม่เปิดให้ใช้งาน</p>
                        </div>

                    @else
                        <div class="space-y-3">
                            @forelse($classmates as $mate)
                                @php $donePeer = in_array($mate->id, $evaluatedPeers); @endphp
                                <div class="anim-item bg-white rounded-3xl border border-border p-5 flex items-center gap-4 {{ $donePeer ? '' : 'card-hover cursor-pointer' }} group relative overflow-hidden">
                                    @unless($donePeer)
                                        <div class="absolute inset-0 bg-gradient-to-r from-violet-50/60 to-fuchsia-50/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-3xl"></div>
                                    @endunless

                                    {{-- Avatar --}}
                                    <div class="w-12 h-12 rounded-2xl {{ $donePeer ? 'bg-slate-100 text-slate-400' : 'bg-violet-100 text-violet-600' }} flex items-center justify-center font-black text-base shrink-0 z-10">
                                        {{ mb_substr($mate->first_name_th, 0, 1) }}
                                    </div>

                                    <div class="flex-1 min-w-0 z-10">
                                        <h3 class="font-bold text-text text-sm leading-snug">{{ $mate->first_name_th }} {{ $mate->last_name_th }}</h3>
                                        <p class="text-[10px] font-bold text-violet-400 uppercase tracking-widest mt-0.5">{{ $mate->student_id }}</p>
                                    </div>

                                    <div class="z-10 shrink-0">
                                        @if($donePeer)
                                            <span class="flex items-center gap-1.5 text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                เรียบร้อย
                                            </span>
                                        @else
                                            <a href="{{ route('student.peer-evaluation', $mate->id) }}"
                                               class="flex items-center gap-1.5 bg-slate-900 hover:bg-violet-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors cursor-pointer shadow-sm active:scale-95">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                                ประเมิน
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white border border-dashed border-border rounded-3xl p-10 text-center flex flex-col items-center">
                                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <p class="font-black text-text">ไม่พบรายชื่อเพื่อนในรุ่น</p>
                                    <p class="text-sm text-text-disabled mt-1">อาจยังไม่มีนักเรียนอื่นในหลักสูตรของคุณ</p>
                                </div>
                            @endforelse
                        </div>
                    @endif
                </section>

            </div>{{-- /grid --}}
        </div>{{-- /content --}}
    </main>
</div>
</x-layouts.student>
