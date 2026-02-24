<x-layouts.app>
<div class="min-h-screen bg-background font-body flex">
    
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <!-- Create/Edit Form -->
        <div class="max-w-3xl mx-auto bg-white rounded-3xl p-8 shadow-sm border border-slate-100"
             x-data="{ questions: {{ count(old('questions', $isEdit ? $topic->questions->pluck('question_text')->toArray() : [])) > 0 ? json_encode(old('questions', $isEdit ? $topic->questions->pluck('question_text')->toArray() : [''])) : '[\'\']' }} }">
            <h2 class="text-xl font-bold text-slate-800 mb-6">{{ $isEdit ? 'แก้ไขแบบสอบถาม' : 'สร้างแบบสอบถามใหม่' }}</h2>
            
            <form action="{{ $isEdit ? route('surveys.update', $topic->id) : route('surveys.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-text-secondary text-sm mb-2">หัวข้อแบบสอบถาม <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $topic->title) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-secondary text-sm mb-2">คำอธิบาย (Optional)</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">{{ old('description', $topic->description) }}</textarea>
                         @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Questions Builder -->
                    <div class="border-t border-border pt-6">
                        <label class="block text-lg font-bold text-slate-800 mb-4">รายการคำถาม (ประเมิน 5 ระดับ)</label>
                        
                        <div class="space-y-3">
                            <template x-for="(q, index) in questions" :key="index">
                                <div class="flex items-center space-x-2">
                                    <span class="text-slate-400 font-bold w-6 text-center" x-text="index + 1 + '.'"></span>
                                    <input type="text" :name="'questions[' + index + ']'" x-model="questions[index]" required placeholder="เช่น ความสะอาดของสถานที่, ความสุภาพของเจ้าหน้าที่" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                    <button type="button" x-show="questions.length > 1" @click="questions.splice(index, 1)" class="p-2 text-text-muted cursor-pointer hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </template>
                            @error("questions.*") <span class="text-red-500 text-xs ml-8">คำถามต้องมีความยามและไม่ซ้ำกัน</span> @enderror
                        </div>
                        <button type="button" @click="questions.push('')" class="mt-4 inline-flex items-center text-blue-600 font-medium text-sm hover:text-blue-700 cursor-pointer">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            เพิ่มคำถาม
                        </button>
                    </div>

                    <div class="pt-4 border-t border-border flex items-center">
                         <input type="checkbox" name="is_active" id="active_status" value="1" {{ old('is_active', $topic->is_active ?? true) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                         <label for="active_status" class="ml-3 block text-sm font-medium text-text-secondary text-sm">เปิดให้นักเรียนประเมิน (Active)</label>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-slate-50">
                        <a href="{{ route('surveys.index') }}" class="px-6 py-2.5 bg-white border border-slate-300 text-slate-700 font-medium rounded-xl hover:bg-slate-50 transition-colors">ยกเลิก</a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 shadow-md shadow-primary/20 transition-colors cursor-pointer">บันทึกข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
</x-layouts.app>
