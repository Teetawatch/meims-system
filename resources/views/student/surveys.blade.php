<x-layouts.student title="แบบสอบถาม">
<div class="min-h-screen flex bg-surface-hover">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-info-light text-primary text-[10px] font-bold uppercase tracking-widest mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                Student Voice
            </div>
            <h1 class="text-3xl font-bold text-text tracking-tight">แบบสอบถามและความพึงพอใจ</h1>
            <p class="text-text-muted font-medium mt-1">เสียงของคุณสำคัญ แสดงความคิดเห็นเพื่อการพัฒนา</p>
        </header>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-4 right-4 bg-green-500 text-white font-bold px-6 py-3 rounded-xl shadow-lg z-50">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-4 right-4 bg-red-500 text-white font-bold px-6 py-3 rounded-xl shadow-lg z-50">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($surveys as $survey)
                @php
                    $isCompleted = in_array($survey->id, $completedSurveyIds);
                @endphp
                <div class="bg-surface rounded-2xl p-8 shadow-sm border border-border flex flex-col group hover:shadow-xl hover:shadow-blue-500/5 transition-all relative overflow-hidden h-full">
                    <!-- Decorate Background -->
                    <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
                         <svg class="w-32 h-32 text-primary transform rotate-12" fill="currentColor" viewBox="0 0 24 24">
                           <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex justify-between items-start mb-6 z-10">
                         <div class="w-16 h-16 rounded-2xl flex items-center justify-center transition-colors shadow-lg shadow-blue-500/10 {{ $isCompleted ? 'bg-emerald-50 text-emerald-500' : 'bg-info-light text-primary group-hover:bg-primary group-hover:text-white' }}">
                             @if($isCompleted)
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                             @endif
                        </div>
                        
                        @if(!$isCompleted)
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-info-light text-primary ring-1 ring-blue-500/10 animate-pulse">
                                New
                            </span>
                        @else
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/10">
                                Completed
                            </span>
                        @endif
                    </div>

                    <div class="mb-6 z-10 flex-1">
                        <h3 class="text-xl font-bold text-text mb-2 leading-tight group-hover:text-primary transition-colors">{{ $survey->title }}</h3>
                        <p class="text-text-muted text-sm line-clamp-3 leading-relaxed">{{ $survey->description }}</p>
                    </div>

                    <div class="mt-auto border-t border-border/50 pt-6 flex items-center justify-between z-10">
                         <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-text-disabled uppercase tracking-widest">Post Date</span>
                            <span class="text-xs font-bold text-text-muted">{{ $survey->created_at->format('d M Y') }}</span>
                        </div>

                        @if($isCompleted)
                            <button disabled class="px-6 py-3 bg-surface-hover text-text-disabled text-xs font-bold rounded-xl cursor-not-allowed flex items-center gap-2">
                                เรียบร้อยแล้ว
                            </button>
                        @else
                            <a href="{{ route('student.surveys.do', $survey) }}"
                                class="px-6 py-3 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-primary shadow-xl shadow-slate-900/10 hover:shadow-blue-600/20 transform active:scale-95 transition-all flex items-center gap-2">
                                เริ่มทำแบบประเมิน
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div class="w-24 h-24 bg-surface-hover rounded-[2rem] flex items-center justify-center text-text-disabled mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-text-disabled">ยังไม่มีแบบสอบถาม</h3>
                    <p class="text-text-disabled text-sm mt-1">ขณะนี้ยังไม่มีแบบสอบถามที่เปิดให้ทำ</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
</x-layouts.student>
