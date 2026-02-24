<x-layouts.student title="ดาวน์โหลดเอกสาร">
<div class="min-h-screen flex bg-surface-hover">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-bold text-text tracking-tight">ดาวน์โหลดเอกสาร</h1>
            <p class="text-text-muted font-medium mt-1">คลังเอกสารและแบบฟอร์มต่างๆ สำหรับนักเรียน</p>
        </header>

        @if($documents->isEmpty())
             <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-border">
                <div class="w-24 h-24 bg-surface-hover rounded-[2rem] flex items-center justify-center text-text-disabled mb-6 animate-bounce">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-text mb-2">ยังไม่มีเอกสาร</h3>
                <p class="text-text-disabled">เมื่อมีเอกสารใหม่จะปรากฏที่นี่</p>
            </div>
        @else
            @php
                $groupedDocuments = $documents->groupBy('category');
                $categoryIcons = [
                    'General' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                    'Handbook' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                    'Form' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                    'Course Material' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                    'Other' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'
                ];
                $categoryTitles = [
                    'General' => 'เอกสารทั่วไป',
                    'Handbook' => 'คู่มือนักเรียน',
                    'Form' => 'แบบฟอร์ม',
                    'Course Material' => 'เอกสารประกอบการเรียน',
                    'Other' => 'อื่นๆ'
                ];
            @endphp

            <div class="space-y-12">
                @foreach($groupedDocuments as $category => $docs)
                    <div class="animate-fade-in-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-info-light text-primary flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $categoryIcons[$category] ?? $categoryIcons['Other'] }}"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-text">{{ $categoryTitles[$category] ?? $category }}</h2>
                            <span class="px-2 py-1 rounded-md bg-surface-hover text-text-muted text-xs font-bold">{{ $docs->count() }} รายการ</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($docs as $doc)
                                <div class="group bg-surface rounded-2xl p-6 shadow-sm border border-border hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1 transition-all flex flex-col h-full relative overflow-hidden">
                                     <!-- File Type Badge -->
                                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-100 transition-opacity">
                                        @if($doc->file_type == 'PDF')
                                            <span class="px-2 py-1 bg-error-light text-error text-[10px] font-bold rounded-lg">PDF</span>
                                        @elseif(in_array($doc->file_type, ['DOC', 'DOCX']))
                                            <span class="px-2 py-1 bg-info-light text-primary text-[10px] font-bold rounded-lg">WORD</span>
                                        @elseif(in_array($doc->file_type, ['XLS', 'XLSX']))
                                            <span class="px-2 py-1 bg-success-light text-success text-[10px] font-bold rounded-lg">EXCEL</span>
                                        @else
                                            <span class="px-2 py-1 bg-surface-hover text-text-secondary text-[10px] font-bold rounded-lg">FILE</span>
                                        @endif
                                    </div>

                                    <div class="w-14 h-14 rounded-2xl mb-4 flex items-center justify-center transition-colors {{ $doc->file_type == 'PDF' ? 'bg-error-light text-error group-hover:bg-red-500 group-hover:text-white' : 'bg-info-light text-primary-light group-hover:bg-blue-500 group-hover:text-white' }}">
                                        @if($doc->file_type == 'PDF')
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        @else
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4 flex-1">
                                        <h3 class="font-bold text-text line-clamp-2 leading-relaxed mb-1">{{ $doc->title }}</h3>
                                        <p class="text-xs text-text-disabled font-medium">{{ $doc->file_size }} • {{ $doc->created_at->format('d M Y') }}</p>
                                    </div>

                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                        class="w-full py-3 rounded-xl bg-surface-hover text-text-secondary text-xs font-bold hover:bg-slate-800 hover:text-white transition-all flex items-center justify-center gap-2 group-hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        ดาวน์โหลด
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</div>
</x-layouts.student>
