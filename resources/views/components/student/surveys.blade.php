<div class="min-h-screen flex bg-slate-50">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                Student Voice
            </div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">แบบสอบถามและความพึงพอใจ</h1>
            <p class="text-slate-500 font-medium mt-1">เสียงของคุณสำคัญ แสดงความคิดเห็นเพื่อการพัฒนา</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($surveys as $survey)
                @php
                    $isCompleted = in_array($survey->id, $completedSurveyIds);
                @endphp
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col group hover:shadow-xl hover:shadow-blue-500/5 transition-all relative overflow-hidden h-full">
                    <!-- Decorate Background -->
                    <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
                         <svg class="w-32 h-32 text-blue-600 transform rotate-12" fill="currentColor" viewBox="0 0 24 24">
                           <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex justify-between items-start mb-6 z-10">
                         <div class="w-16 h-16 rounded-2xl flex items-center justify-center transition-colors shadow-lg shadow-blue-500/10 {{ $isCompleted ? 'bg-emerald-50 text-emerald-500' : 'bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white' }}">
                             @if($isCompleted)
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                             @endif
                        </div>
                        
                        @if(!$isCompleted)
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 ring-1 ring-blue-500/10 animate-pulse">
                                New
                            </span>
                        @else
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/10">
                                Completed
                            </span>
                        @endif
                    </div>

                    <div class="mb-6 z-10 flex-1">
                        <h3 class="text-xl font-black text-slate-800 mb-2 leading-tight group-hover:text-blue-600 transition-colors">{{ $survey->title }}</h3>
                        <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed">{{ $survey->description }}</p>
                    </div>

                    <div class="mt-auto border-t border-slate-50 pt-6 flex items-center justify-between z-10">
                         <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Post Date</span>
                            <span class="text-xs font-bold text-slate-500">{{ $survey->created_at->format('d M Y') }}</span>
                        </div>

                        @if($isCompleted)
                            <button disabled class="px-6 py-3 bg-slate-100 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed flex items-center gap-2">
                                เรียบร้อยแล้ว
                            </button>
                        @else
                            <a href="{{ route('student.surveys.do', $survey) }}"
                                class="px-6 py-3 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-blue-600 shadow-xl shadow-slate-900/10 hover:shadow-blue-600/20 transform active:scale-95 transition-all flex items-center gap-2">
                                เริ่มทำแบบประเมิน
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div class="w-24 h-24 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-300 mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-400">ยังไม่มีแบบสอบถาม</h3>
                    <p class="text-slate-400 text-sm mt-1">ขณะนี้ยังไม่มีแบบสอบถามที่เปิดให้ทำ</p>
                </div>
            @endforelse
        </div>
    </main>
</div>