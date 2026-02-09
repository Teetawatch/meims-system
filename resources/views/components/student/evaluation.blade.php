<div class="min-h-screen flex bg-slate-50">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 text-center md:text-left">
            <h1 class="text-4xl font-black text-slate-800 tracking-tight mb-2">ระบบประเมินผล</h1>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-sm">ประเมินอาจารย์ผู้สอน และเพื่อนร่วมห้อง
            </p>
        </header>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <!-- Teacher Evaluation -->
            <section>
                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">ประเมินอาจารย์ผู้สอน</h2>
                </div>

                <div class="space-y-4">
                    @forelse($subjects as $subject)
                        <div
                            class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex justify-between items-center group hover:border-blue-500/30 transition-all">
                            <div>
                                <h3 class="text-lg font-black text-slate-800">{{ $subject->subject_name_th }}</h3>
                                <p class="text-sm text-slate-500 font-bold uppercase tracking-wider">
                                    {{ $subject->subject_code }} •
                                    อ.{{ $subject->teacher ? $subject->teacher->first_name_th : 'ไม่ระบุ' }}</p>
                            </div>
                            @if(in_array($subject->id, $evaluatedTeachers))
                                <span
                                    class="px-4 py-2 bg-emerald-50 text-emerald-600 text-xs font-black rounded-xl border border-emerald-100 uppercase">ประเมินแล้ว</span>
                            @else
                                <a href="{{ route('student.teacher-evaluation', $subject->id) }}"
                                    class="px-6 py-2 bg-slate-900 text-white text-xs font-black rounded-xl hover:bg-blue-600 transition-all shadow-lg shadow-slate-900/10 transform active:scale-95">ประเมินเลย</a>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white p-12 rounded-[2rem] text-center border border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold">ไม่มีรายวิชาที่ต้องประเมินในขณะนี้</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Peer Evaluation -->
            @if($peerEvaluationEnabled)
            <section>
                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">ประเมินเพื่อนร่วมห้อง</h2>
                </div>

                <div class="space-y-4">
                    @forelse($classmates as $mate)
                        <div
                            class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex justify-between items-center group hover:border-indigo-500/30 transition-all">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-black text-xs">
                                    {{ mb_substr($mate->first_name_th, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-800">{{ $mate->first_name_th }}
                                        {{ $mate->last_name_th }}</h3>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                        {{ $mate->student_id }}</p>
                                </div>
                            </div>
                            @if(in_array($mate->id, $evaluatedPeers))
                                <span
                                    class="px-4 py-2 bg-emerald-50 text-emerald-600 text-xs font-black rounded-xl border border-emerald-100 uppercase">ประเมินแล้ว</span>
                            @else
                                <a href="{{ route('student.peer-evaluation', $mate->id) }}"
                                    class="px-6 py-2 bg-slate-900 text-white text-xs font-black rounded-xl hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/10 transform active:scale-95">ประเมิน</a>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white p-12 rounded-[2rem] text-center border border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold">ไม่พบรายชื่อเพื่อนในรุ่นเดียวกัน</p>
                        </div>
                    @endforelse
                </div>
            </section>
            @else
            <section>
                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-12 h-12 bg-slate-200 rounded-2xl flex items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-300 tracking-tight">ประเมินเพื่อนร่วมห้อง</h2>
                </div>
                <div class="bg-white p-12 rounded-[2rem] text-center border border-dashed border-slate-200">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <p class="text-slate-500 font-bold text-sm">ระบบประเมินเพื่อนร่วมห้องยังไม่เปิดให้ใช้งาน</p>
                    <p class="text-slate-400 text-xs mt-1">กรุณารอผู้ดูแลระบบเปิดให้ประเมิน</p>
                </div>
            </section>
            @endif
        </div>
    </main>
</div>