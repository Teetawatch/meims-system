<div class="min-h-screen bg-slate-50 font-['Outfit','Anuphan'] flex">
    
    <x-sidebar />

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        
        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">จัดการแบบสอบถามความพึงพอใจ</h1>
                <p class="text-slate-500">สร้างและจัดการหัวข้อแบบประเมินสำหรับนักเรียน (5 ระดับ)</p>
            </div>
            
            @if($viewState === 'list')
                <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    สร้างแบบสอบถาม
                </button>
            @elseif($viewState === 'results')
                <button wire:click="cancel" class="inline-flex items-center px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-sm font-medium rounded-xl transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    กลับหน้ารายการ
                </button>
            @endif
        </header>

        <!-- List View -->
        @if($viewState === 'list')
            <div class="mb-6">
                <input type="text" wire:model.live="search" placeholder="ค้นหาหัวข้อแบบสอบถาม..." class="max-w-md w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($topics as $topic)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <span class="inline-flex px-2 py-1 text-xs font-bold rounded-full {{ $topic->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $topic->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <div class="flex space-x-1">
                                <button wire:click="edit({{ $topic->id }})" class="p-2 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50" title="แก้ไข">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $topic->id }})" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50" title="ลบ">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-800 mb-2 line-clamp-2">{{ $topic->title }}</h3>
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
                            <button wire:click="viewResults({{ $topic->id }})" class="px-4 py-2 bg-slate-50 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-100 transition-colors">
                                ดูผลประเมิน
                            </button>
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
        @endif

        <!-- Create/Edit Form -->
        @if($viewState === 'create' || $viewState === 'edit')
            <div class="max-w-3xl mx-auto bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold text-slate-800 mb-6">{{ $viewState === 'create' ? 'สร้างแบบสอบถามใหม่' : 'แก้ไขแบบสอบถาม' }}</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">หัวข้อแบบสอบถาม <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="title" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">คำอธิบาย (Optional)</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"></textarea>
                         @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Questions Builder -->
                    <div class="border-t border-slate-100 pt-6">
                        <label class="block text-lg font-bold text-slate-800 mb-4">รายการคำถาม (ประเมิน 5 ระดับ)</label>
                        <div class="space-y-3">
                            @foreach($questions as $index => $question)
                                <div class="flex items-center space-x-2">
                                    <span class="text-slate-400 font-bold w-6 text-center">{{ $loop->iteration }}.</span>
                                    <input type="text" wire:model="questions.{{ $index }}" placeholder="เช่น ความสะอาดของสถานที่, ความสุภาพของเจ้าหน้าที่" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                    @if(count($questions) > 1)
                                        <button wire:click="removeQuestion({{ $index }})" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @endif
                                </div>
                                @error("questions.$index") <span class="text-red-500 text-xs ml-8">{{ $message }}</span> @enderror
                            @endforeach
                        </div>
                        <button wire:click="addQuestion" class="mt-4 inline-flex items-center text-blue-600 font-medium text-sm hover:text-blue-700">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            เพิ่มคำถาม
                        </button>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center">
                         <input type="checkbox" wire:model="is_active" id="active_status" class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                         <label for="active_status" class="ml-3 block text-sm font-medium text-slate-700">เปิดให้นักเรียนประเมิน (Active)</label>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-slate-50">
                        <button wire:click="cancel" class="px-6 py-2.5 bg-white border border-slate-300 text-slate-700 font-medium rounded-xl hover:bg-slate-50 transition-colors">ยกเลิก</button>
                        <button wire:click="save" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-colors">บันทึกข้อมูล</button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Results View -->
        @if($viewState === 'results' && $selectedTopic)
            <div class="space-y-8">
                <!-- Header Card -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">{{ $selectedTopic->title }}</h2>
                    <p class="text-slate-500 text-sm mb-6">{{ $selectedTopic->description }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="bg-blue-50 p-6 rounded-2xl text-center">
                            <p class="text-sm text-blue-500 font-bold uppercase">คะแนนเฉลี่ยรวม</p>
                            <div class="flex items-end justify-center mt-2">
                                <span class="text-4xl font-black text-blue-600 mr-2">{{ number_format($selectedTopic->average_score, 1) }}</span>
                                <span class="text-sm text-blue-400 mb-1">/ 5.0</span>
                            </div>
                        </div>
                        <div class="bg-slate-50 p-6 rounded-2xl text-center">
                            <p class="text-sm text-slate-500 font-bold uppercase">ผู้ประเมิน</p>
                            <div class="flex items-end justify-center mt-2">
                                <span class="text-4xl font-black text-slate-700 mr-2">{{ $selectedTopic->total_responses }}</span>
                                <span class="text-sm text-slate-400 mb-1">คน</span>
                            </div>
                        </div>
                    </div>
                     
                    <div class="mt-8 pt-6 border-t border-slate-100">
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
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach($selectedTopic->questions as $question)
                                            @php
                                                $qAvg = $question->answers->avg('score') ?? 0;
                                                $width = ($qAvg / 5) * 100;
                                                $color = $qAvg >= 4 ? 'bg-green-500' : ($qAvg >= 3 ? 'bg-yellow-400' : 'bg-red-400');
                                            @endphp
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-6 py-4 text-sm font-medium text-slate-700">{{ $question->question_text }}</td>
                                                <td class="px-6 py-4 text-center text-sm font-bold text-slate-800">{{ number_format($qAvg, 1) }}</td>
                                                <td class="px-6 py-4">
                                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                                        <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ $width }}%"></div>
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
        @endif

    </main>
</div>
