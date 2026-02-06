<div class="min-h-screen flex bg-slate-50">
    <x-student-sidebar />
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">ตารางเรียน</h1>
            <p class="text-slate-500 font-medium mt-1">ตรวจสอบตารางเรียนและประกาศจากฝ่ายวิชาการ</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($timetables as $timetable)
                <div
                    class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col group hover:shadow-xl hover:shadow-blue-500/5 transition-all transform hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-black text-slate-800 mb-2 truncate">{{ $timetable->title }}</h3>
                    <p class="text-slate-500 text-sm mb-6 line-clamp-2">{{ $timetable->description }}</p>

                    <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                        <span
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $timetable->created_at->format('d M Y') }}</span>
                        <a href="{{ asset('storage/' . $timetable->file_path) }}" target="_blank"
                            class="px-5 py-2.5 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-black transition-colors">
                            เปิดดูไฟล์ PDF
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div
                        class="w-24 h-24 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-300 mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-400">ยังไม่มีข้อมูลตารางเรียน</h3>
                    <p class="text-slate-400">กรุณาติดตามประกาศจากฝ่ายวิชาการ</p>
                </div>
            @endforelse
        </div>
    </main>
</div>