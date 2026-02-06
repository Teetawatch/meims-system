<div class="min-h-screen flex bg-slate-50">
    <x-student-sidebar />
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">ดาวน์โหลดเอกสาร</h1>
            <p class="text-slate-500 font-medium mt-1">คลังเอกสารและแบบฟอร์มต่างๆ สำหรับนักเรียน</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($documents as $doc)
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex items-center gap-6 group hover:shadow-xl hover:shadow-slate-200/50 transition-all border-l-4 {{ $doc->file_type == 'PDF' ? 'border-l-red-500' : 'border-l-blue-500' }}">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all shadow-sm">
                        @if($doc->file_type == 'PDF')
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        @else
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @endif
                    </div>
                    
                    <div class="flex-1 overflow-hidden">
                        <div class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-0.5">{{ $doc->category }}</div>
                        <h3 class="text-md font-bold text-slate-800 line-clamp-1">{{ $doc->title }}</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $doc->file_type }} • {{ $doc->file_size }}</p>
                    </div>

                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                        class="p-3 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div class="w-24 h-24 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-300 mx-auto mb-6">
                         <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-400">คลังเอกสารยังว่างเปล่า</h3>
                    <p class="text-slate-400 text-sm mt-2">ยังไม่มีเอกสารที่เปิดให้ดาวน์โหลดในขณะนี้</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
