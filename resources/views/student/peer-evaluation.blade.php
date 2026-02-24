<x-layouts.student title="แบบประเมินเพื่อนร่วมห้อง">
<div class="min-h-screen flex bg-surface-hover">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <div class="max-w-3xl mx-auto">
            <header class="mb-10">
                <a href="{{ route('student.evaluation') }}"
                    class="inline-flex items-center text-text-disabled hover:text-text-secondary font-bold text-xs uppercase tracking-widest mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    กลับหน้าหลัก
                </a>
                <h1 class="text-3xl font-bold text-text tracking-tight">แบบประเมินเพื่อนร่วมห้อง</h1>
                <p class="text-text-muted font-bold uppercase tracking-widest text-sm mt-1">
                    ประเมินทักษะทางสังคมและการทำงานร่วมกัน</p>
            </header>

            <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="flex items-center gap-6 mb-12 pb-8 border-b border-border/50">
                        <div
                            class="w-20 h-20 bg-indigo-50 rounded-3xl flex items-center justify-center text-indigo-600 font-bold text-2xl shadow-inner">
                            {{ mb_substr($targetStudent->first_name_th, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-text-disabled uppercase tracking-widest mb-1">
                                เพื่อนร่วมห้องที่รับการประเมิน</p>
                            <h2 class="text-2xl font-bold text-text">{{ $targetStudent->first_name_th }}
                                {{ $targetStudent->last_name_th }}</h2>
                            <p class="text-sm text-text-disabled font-bold uppercase tracking-widest">
                                {{ $targetStudent->student_id }}</p>
                        </div>
                    </div>

                    <form action="{{ route('student.peer-evaluation.store', $targetStudentId) }}" method="POST" class="space-y-10">
                        @csrf
                        @php
                            $peerCriteria = [
                                'rating_contribution' => 'ความตั้งใจและการมีส่วนร่วมในงานกลุ่ม',
                                'rating_responsibility' => 'ความรับผิดชอบต่อหน้าที่ที่ได้รับมอบหมาย',
                                'rating_teamwork' => 'การรับฟังความคิดเห็นและการปรับตัวเข้ากับทีม',
                                'rating_interpersonal' => 'มนุษยสัมพันธ์และการช่วยเหลือผู้อื่น'
                            ];
                        @endphp

                        @foreach($peerCriteria as $key => $label)
                            <div class="space-y-4" x-data="{ rating: {{ old($key, 0) }} }">
                                <label class="text-sm font-bold text-text-secondary tracking-tight block">{{ $label }} <span
                                        class="text-error">*</span></label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="{{ $key }}" value="{{ $i }}" x-model="rating" class="hidden">
                                            <div :class="rating >= {{ $i }} ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'bg-surface-hover text-text-disabled hover:bg-slate-100'"
                                                class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all transform active:scale-90">
                                                <span class="font-bold">{{ $i }}</span>
                                            </div>
                                        </label>
                                    @endfor
                                </div>
                                @error($key) <span class="text-error text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        @endforeach

                        <div class="pt-4">
                            <label
                                class="text-sm font-bold text-text-secondary tracking-tight block mb-4">ความคิดเห็นต่อเพื่อนคนนี้</label>
                            <textarea name="comment" rows="4"
                                placeholder="แสดงความชื่นชม หรือข้อเสนอแนะในการทำงานร่วมกัน..."
                                class="w-full px-6 py-4 bg-surface-hover border border-border rounded-[2rem] focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all placeholder:text-text-disabled">{{ old('comment') }}</textarea>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full py-5 bg-slate-900 text-white font-bold rounded-[2rem] hover:bg-black transition-all shadow-xl shadow-slate-900/15 transform active:scale-95 flex items-center justify-center gap-3">
                                <span>ส่งผลการประเมินเพื่อน</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
</x-layouts.student>
