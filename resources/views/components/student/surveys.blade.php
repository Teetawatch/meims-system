<div class="min-h-screen flex bg-slate-50">
    <x-student-sidebar />
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">แบบสอบถามและความพึงพอใจ</h1>
            <p class="text-slate-500 font-medium mt-1">แสดงความคิดเห็นเพื่อการพัฒนาระบบการเรียนการสอน</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($surveys as $survey)
                <div
                    class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col group hover:shadow-2xl hover:shadow-blue-500/10 transition-all transform hover:-translate-y-2 relative overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-6 right-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/10">
                            Active
                        </span>
                    </div>

                    <div
                        class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-lg shadow-blue-500/10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-black text-slate-800 mb-2">{{ $survey->title }}</h3>
                    <p class="text-slate-500 text-sm mb-8 line-clamp-3 leading-relaxed">{{ $survey->description }}</p>

                    <div class="mt-auto pt-8 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">เริ่มเมื่อ</span>
                            <span
                                class="text-xs font-bold text-slate-600 italic">{{ $survey->created_at->format('d/m/Y') }}</span>
                        </div>
                        <a href="#"
                            class="px-8 py-3 bg-blue-600 text-white text-sm font-black rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 transform active:scale-95 transition-all">
                            ทำแบบประเมิน
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div
                        class="w-24 h-24 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-300 mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-400">ยังไม่มีแบบสอบถามที่เปิดให้นักเรียนทำในขณะนี้</h3>
                </div>
            @endforelse
        </div>
    </main>
</div>