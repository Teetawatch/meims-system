<div class="min-h-screen flex bg-slate-50">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <div class="max-w-3xl mx-auto">
            <header class="mb-10">
                <a href="{{ route('student.evaluation') }}"
                    class="inline-flex items-center text-slate-400 hover:text-slate-600 font-bold text-xs uppercase tracking-widest mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    กลับหน้าหลัก
                </a>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">แบบประเมินอาจารย์ผู้สอน</h1>
                <p class="text-slate-500 font-bold uppercase tracking-widest text-sm mt-1">วิชา:
                    {{ $subject->subject_name_th }} ({{ $subject->subject_code }})</p>
            </header>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="flex items-center gap-6 mb-12 pb-8 border-b border-slate-50">
                        <div
                            class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center text-blue-600 font-black text-2xl">
                            {{ mb_substr($subject->teacher->first_name_th ?? 'อ', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">อาจารย์ผู้สอน
                            </p>
                            <h2 class="text-2xl font-black text-slate-800">
                                อ.{{ $subject->teacher ? $subject->teacher->title_th . $subject->teacher->first_name_th . ' ' . $subject->teacher->last_name_th : 'ไม่ระบุ' }}
                            </h2>
                        </div>
                    </div>

                    <form wire:submit.prevent="submit" class="space-y-10">
                        @php
                            $criteria = [
                                'rating_knowledge' => 'ความเชี่ยวชาญในเนื้อหาวิชา',
                                'rating_method' => 'วิธีการสอนและการถ่ายทอดความรู้',
                                'rating_attitude' => 'เจคติและความเมตตาต่อศิษย์',
                                'rating_timeliness' => 'การตรงต่อเวลาและการรักษาเวลา',
                                'rating_support' => 'การให้คำปรึกษาและสนับสนุนนอกเวลาเรียน'
                            ];
                        @endphp

                        @foreach($criteria as $key => $label)
                            <div class="space-y-4">
                                <label class="text-sm font-black text-slate-700 tracking-tight block">{{ $label }} <span
                                        class="text-red-500">*</span></label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" wire:click="setRating('{{ $key }}', {{ $i }})"
                                            class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all transform active:scale-90 {{ $this->$key >= $i ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">
                                            <span class="font-black">{{ $i }}</span>
                                        </button>
                                    @endfor
                                </div>
                                @error($key) <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        @endforeach

                        <div class="pt-4">
                            <label
                                class="text-sm font-black text-slate-700 tracking-tight block mb-4">ข้อเสนอแนะเพิ่มเติม</label>
                            <textarea wire:model="comment" rows="4" placeholder="แสดงความคิดเห็น หรือข้อเสนอแนะต่างๆ..."
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-[2rem] focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder:text-slate-300"></textarea>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full py-5 bg-slate-900 text-white font-black rounded-[2rem] hover:bg-black transition-all shadow-2xl shadow-slate-900/20 transform active:scale-95 flex items-center justify-center gap-3">
                                <span>ส่งผลการประเมิน</span>
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