<div class="p-8 md:p-12">

        <header class="mb-10">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">ตารางเรียน</h1>
            <p class="text-slate-500 font-medium mt-1">ตรวจสอบตารางเรียนและประกาศจากฝ่ายวิชาการ</p>
        </header>

        @if($timetables->isNotEmpty())
            @php
                $latestTimetable = $timetables->first();
                $olderTimetables = $timetables->slice(1);
            @endphp

            <!-- Latest Timetable Hero Section -->
            <div
                class="bg-white rounded-[2.5rem] p-6 md:p-10 shadow-xl shadow-slate-200/50 mb-12 border border-slate-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-64 h-64 text-blue-600 transform rotate-12" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z" />
                        <path d="M7 7h10v2H7zm0 4h10v2H7zm0 4h7v2H7z" />
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        <div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-600 mb-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500 mr-2 animate-pulse"></span>
                                ล่าสุด
                            </span>
                            <h2 class="text-2xl md:text-3xl font-black text-slate-800">{{ $latestTimetable->title }}</h2>
                            <p class="text-slate-500 mt-1">{{ $latestTimetable->description }}</p>
                        </div>
                        <a href="{{ asset('storage/' . $latestTimetable->file_path) }}" target="_blank"
                            class="px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all hover:scale-105 shadow-lg shadow-slate-900/20 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            ดาวน์โหลด PDF
                        </a>
                    </div>

                    <!-- PDF Preview Frame -->
                    <div
                        class="w-full h-[600px] bg-slate-100 rounded-2xl border border-slate-200 overflow-hidden shadow-inner">
                        <iframe src="{{ asset('storage/' . $latestTimetable->file_path) }}" class="w-full h-full"
                            frameborder="0">
                            <div class="flex items-center justify-center h-full text-slate-400">
                                <p>อุปกรณ์ของคุณไม่รองรับการแสดงตัวอย่าง PDF กรุณาดาวน์โหลดไฟล์เพื่อเปิดดู</p>
                            </div>
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Older Timetables Grid -->
            @if($olderTimetables->isNotEmpty())
                <h3 class="text-xl font-black text-slate-800 mb-6">ตารางเรียนย้อนหลัง</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($olderTimetables as $timetable)
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
                                    เปิดดูไฟล์
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div
                class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200">
                <div
                    class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300 mb-6 animate-bounce">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2">ยังไม่มีข้อมูลตารางเรียน</h3>
                <p class="text-slate-400">กรุณาติดตามประกาศจากฝ่ายวิชาการในภายหลัง</p>
            </div>
        @endif
</div>