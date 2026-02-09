<div class="min-h-screen flex bg-slate-50">
    <!-- Sidebar Container -->
    <aside
        class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">ระบบประเมินผล</h1>
            <p class="text-slate-500 font-medium mt-1">ประเมินอาจารย์ผู้สอน และเพื่อนร่วมห้องเพื่อการพัฒนาที่ดียิ่งขึ้น
            </p>
        </header>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <!-- Teacher Evaluation -->
            <section class="space-y-6">
                <div class="flex items-center gap-4 mb-2">
                    <div
                        class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">ประเมินอาจารย์</h2>
                        <p class="text-slate-400 text-sm font-medium">รายวิชาเรียนในภาคการศึกษานี้</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($subjects as $subject)
                        <div
                            class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col sm:flex-row justify-between items-center group hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1 transition-all gap-6 relative overflow-hidden">
                            <!-- Background Decoration -->
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full blur-3xl -mr-16 -mt-16 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                            </div>

                            <div class="flex items-center gap-4 w-full sm:w-auto z-10">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center font-black text-lg shadow-inner">
                                    {{ substr($subject->subject_code, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">
                                        {{ $subject->subject_code }}</div>
                                    <h3 class="text-lg font-bold text-slate-800 leading-tight">
                                        {{ $subject->subject_name_th }}</h3>
                                    <p class="text-sm text-slate-400 font-medium mt-1">
                                        อ.{{ $subject->teacher ? $subject->teacher->first_name_th : 'ไม่ระบุ' }}</p>
                                </div>
                            </div>

                            <div class="z-10 w-full sm:w-auto">
                                @if(in_array($subject->id, $evaluatedTeachers))
                                    <span
                                        class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-400 text-xs font-bold rounded-xl flex items-center justify-center gap-2 cursor-default">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        ประเมินแล้ว
                                    </span>
                                @else
                                    <a href="{{ route('student.teacher-evaluation', $subject->id) }}"
                                        class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 transform active:scale-95 flex items-center justify-center gap-2">
                                        เริ่มการประเมิน
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div
                            class="bg-white p-12 rounded-[2.5rem] text-center border border-dashed border-slate-200 flex flex-col items-center justify-center">
                            <div
                                class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-slate-800 font-bold text-lg">ยังไม่มีรายการประเมิน</p>
                            <p class="text-slate-400 text-sm mt-1">คุณได้ทำการประเมินครบถ้วนแล้ว
                                หรือยังไม่ถึงช่วงเวลาประเมิน</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Peer Evaluation -->
            @if($peerEvaluationEnabled)
                <section class="space-y-6">
                    <div class="flex items-center gap-4 mb-2">
                        <div
                            class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-slate-800 tracking-tight">ประเมินเพื่อนร่วมรุ่น</h2>
                            <p class="text-slate-400 text-sm font-medium">ประเมินพฤติกรรมและการมีส่วนร่วม</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($classmates as $mate)
                            <div
                                class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center group hover:shadow-xl hover:shadow-indigo-500/5 hover:-translate-y-1 transition-all relative overflow-hidden">
                                <!-- Background Decoration -->
                                <div
                                    class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full blur-3xl -mr-16 -mt-16 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                </div>

                                <div class="flex items-center gap-4 z-10">
                                    <div
                                        class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 font-black text-lg shadow-inner">
                                        {{ mb_substr($mate->first_name_th, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-800 leading-tight">{{ $mate->first_name_th }}
                                            {{ $mate->last_name_th }}</h3>
                                        <p class="text-[10px] text-indigo-500 font-black uppercase tracking-widest mt-1">
                                            {{ $mate->student_id }}</p>
                                    </div>
                                </div>

                                <div class="z-10">
                                    @if(in_array($mate->id, $evaluatedPeers))
                                        <span
                                            class="px-4 py-2 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg border border-emerald-100 uppercase flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            เรียบร้อย
                                        </span>
                                    @else
                                        <a href="{{ route('student.peer-evaluation', $mate->id) }}"
                                            class="w-10 h-10 bg-slate-900 text-white rounded-xl hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/10 transform active:scale-90 flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="bg-white p-12 rounded-[2.5rem] text-center border border-dashed border-slate-200">
                                <div
                                    class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-bold">ไม่พบรายชื่อเพื่อนในรุ่นเดียวกัน</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            @else
                <section class="space-y-6">
                    <div class="flex items-center gap-4 mb-2 opacity-50">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-slate-400 tracking-tight">ประเมินเพื่อนร่วมรุ่น</h2>
                            <p class="text-slate-300 text-sm font-medium">ยังไม่เปิดให้ใช้งาน</p>
                        </div>
                    </div>
                    <div
                        class="bg-slate-50 p-12 rounded-[2.5rem] text-center border-2 border-dashed border-slate-200 flex flex-col items-center justify-center h-64">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-slate-500 font-bold text-lg">Coming Soon</p>
                        <p class="text-slate-400 text-sm mt-1">ระบบประเมินเพื่อนร่วมรุ่นยังไม่เปิดให้ใช้งานในขณะนี้</p>
                    </div>
                </section>
            @endif
        </div>
    </main>
</div>