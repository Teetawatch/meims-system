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
            
            <a href="{{ route('surveys.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-sm font-medium rounded-xl transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                กลับหน้ารายการ
            </a>
        </header>

        <!-- Results View -->
        <div class="space-y-8">
            <!-- Header Card -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h2 class="text-2xl font-bold text-slate-800 mb-2">{{ $selectedTopic->title }}</h2>
                <p class="text-slate-500 text-sm mb-6">{{ $selectedTopic->description }}</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="bg-blue-50 p-6 rounded-2xl text-center">
                        <p class="text-sm text-blue-500 font-bold uppercase">คะแนนเฉลี่ยรวม</p>
                        <div class="flex items-end justify-center mt-2">
                            <span class="text-4xl font-bold text-blue-600 mr-2">{{ number_format($selectedTopic->average_score, 1) }}</span>
                            <span class="text-sm text-blue-400 mb-1">/ 5.0</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-2xl text-center">
                        <p class="text-sm text-slate-500 font-bold uppercase">ผู้ประเมิน</p>
                        <div class="flex items-end justify-center mt-2">
                            <span class="text-4xl font-bold text-slate-700 mr-2">{{ $selectedTopic->total_responses }}</span>
                            <span class="text-sm text-slate-400 mb-1">คน</span>
                        </div>
                    </div>
                </div>
                    
                <div class="mt-8 pt-6 border-t border-border">
                    <h4 class="text-sm font-bold text-slate-700 mb-2">ลิงก์สำหรับประเมิน</h4>
                        <div class="flex items-center space-x-3">
                        <div class="bg-slate-100 px-4 py-2 rounded-lg text-sm text-slate-600 font-mono select-all flex-1">
                            {{ url('/surveys/'.$selectedTopic->id) }}
                        </div>
                        <!-- Copy button placeholder -->
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Questions Breakdown -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                            <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="font-bold text-lg text-slate-800">แยกตามรายข้อ</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-white border-b border-slate-100">
                                    <tr class="text-slate-500 text-xs font-semibold uppercase tracking-wider">
                                        <th class="px-6 py-4">ข้อคำถาม</th>
                                        <th class="px-6 py-4 text-center w-32">เฉลี่ย</th>
                                        <th class="px-6 py-4 w-48">ระดับ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border/50">
                                    @foreach($selectedTopic->questions as $question)
                                        @php
                                            $qAvg = $question->answers->avg('score') ?? 0;
                                            $width = ($qAvg / 5) * 100;
                                            $color = $qAvg >= 4 ? 'bg-green-500' : ($qAvg >= 3 ? 'bg-yellow-400' : 'bg-red-400');
                                        @endphp
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 text-sm font-medium text-text-secondary text-sm">{{ $question->question_text }}</td>
                                            <td class="px-6 py-4 text-center text-sm font-bold text-slate-800">{{ number_format($qAvg, 1) }}</td>
                                            <td class="px-6 py-4">
                                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                                    <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ $width }}%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Suggestions / Comments -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden h-full flex flex-col">
                        <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="font-bold text-lg text-slate-800">ข้อเสนอแนะเพิ่มเติม</h3>
                        </div>
                        <div class="overflow-y-auto max-h-[500px] p-0">
                            @forelse($selectedTopic->responses as $response)
                                @if($response->comment)
                                <div class="p-6 border-b border-slate-50 hover:bg-slate-50/30 transition-colors last:border-0">
                                    <p class="text-slate-600 text-sm italic">"{{ $response->comment }}"</p>
                                    <div class="mt-3 flex justify-between items-center">
                                        <span class="text-xs text-slate-400 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $response->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <div class="p-12 text-center text-slate-400">
                                    ยังไม่มีข้อเสนอแนะ
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</x-layouts.app>
