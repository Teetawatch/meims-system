<x-layouts.app>
<div class="min-h-screen bg-background font-body flex">
    
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        
        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-text">จัดการแบบสอบถามความพึงพอใจ</h1>
                <p class="text-text-muted text-sm font-medium">สร้างและจัดการหัวข้อแบบประเมินสำหรับนักเรียน (5 ระดับ)</p>
            </div>
            
            <a href="{{ route('surveys.create') }}" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl transition-colors shadow-md shadow-primary/20">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                สร้างแบบสอบถาม
            </a>
        </header>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- List View -->
        <div class="mb-6">
            <form action="{{ route('surveys.index') }}" method="GET">
                <div class="relative max-w-md">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="ค้นหาหัวข้อแบบสอบถาม... (แล้วกด Enter)" class="w-full pl-10 pr-4 py-3 bg-white border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all shadow-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-text-disabled" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($topics as $topic)
                <div class="bg-surface rounded-2xl p-6 shadow-card border border-border hover:shadow-md transition-shadow flex flex-col h-full">
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex px-2 py-1 text-xs font-bold rounded-full {{ $topic->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $topic->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <div class="flex space-x-1">
                            <a href="{{ route('surveys.edit', $topic->id) }}" class="p-2 text-text-muted cursor-pointer hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-colors inline-block" title="แก้ไข">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('surveys.destroy', $topic->id) }}" method="POST" class="inline-block" onsubmit="return confirm('หากลบแบบสอบถามนี้ ข้อมูลผลการประเมินทั้งหมดจะหายไป! คุณแน่ใจหรือไม่?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-text-muted cursor-pointer hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="ลบ">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-800 mb-2 line-clamp-2">{{ $topic->title }}</h3>
                    
                    <div class="mb-3">
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-md {{ $topic->course_id ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-slate-50 text-slate-600 border border-slate-200' }}">
                            @if($topic->course)
                                {{ $topic->course->course_name_th }}
                            @else
                                ทุกหลักสูตร
                            @endif
                        </span>
                    </div>

                    <p class="text-slate-500 text-sm mb-6 flex-1 line-clamp-3">{{ $topic->description ?? 'ไม่มีคำอธิบาย' }}</p>

                    <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                        <div class="text-center">
                            <p class="text-xs text-slate-400">ผู้ตอบแบบสอบถาม</p>
                            <p class="font-bold text-slate-800">{{ $topic->responses_count }} คน</p>
                        </div>
                         <div class="text-center">
                            <p class="text-xs text-slate-400">คะแนนเฉลี่ย</p>
                            <p class="font-bold text-blue-600">{{ number_format($topic->average_score, 1) }}</p>
                        </div>
                        <a href="{{ route('surveys.show', $topic->id) }}" class="px-4 py-2 bg-slate-50 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-100 transition-colors inline-block text-center cursor-pointer">
                            ดูผลประเมิน
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-3xl border border-slate-100 border-dashed">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <p>ยังไม่มีแบบสอบถาม</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-6">
            {{ $topics->links() }}
        </div>
    </main>
</div>
</x-layouts.app>
