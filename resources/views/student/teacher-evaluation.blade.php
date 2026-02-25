<x-layouts.student title="แบบประเมินอาจารย์ผู้สอน">
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
                <h1 class="text-3xl font-bold text-text tracking-tight">แบบประเมินอาจารย์ผู้สอน</h1>
                <p class="text-text-muted font-bold uppercase tracking-widest text-sm mt-1">วิชา:
                    {{ $subject->subject_name_th }} ({{ $subject->subject_code }})</p>
            </header>

            <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="flex items-center gap-6 mb-12 pb-8 border-b border-border/50">
                        <div class="w-20 h-20 bg-info-light rounded-3xl flex items-center justify-center text-primary font-bold text-2xl">
                            {{ mb_substr($teacher->first_name_th ?? 'อ', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-text-disabled uppercase tracking-widest mb-1">อาจารย์ผู้สอน</p>
                            <h2 class="text-2xl font-bold text-text">
                                อ.{{ $teacher->title_th . $teacher->first_name_th . ' ' . $teacher->last_name_th }}
                            </h2>
                        </div>
                    </div>

                    <form action="{{ route('student.teacher-evaluation.store', [$subjectId, $teacherId]) }}" method="POST" class="space-y-10">
                        @csrf

                        {{-- ส่วนที่ 1: หัวข้อประเมิน 7 ข้อ --}}
                        <div class="mb-2">
                            <h3 class="text-base font-black text-slate-800 tracking-tight">ส่วนที่ 1 – เกณฑ์การประเมิน</h3>
                            <p class="text-xs text-slate-400 font-bold mt-0.5">กรุณาให้คะแนน 1 (น้อยที่สุด) ถึง 5 (มากที่สุด)</p>
                        </div>

                        @php
                            $criteria = [
                                'rating_knowledge'     => '1. มีความรอบรู้ในเนื้อหาวิชา',
                                'rating_method'        => '2. มีเทคนิค และถ่ายทอดความรู้ความเข้าใจให้ผู้รับการอบรมเข้าใจ',
                                'rating_content_order' => '3. จัดลำดับความสัมพันธ์ของเนื้อหาวิชาที่สอนอย่างเหมาะสม',
                                'rating_motivation'    => '4. สร้างบรรยากาศ จูงใจให้ผู้เข้ารับการอบรมมีความสนใจการฝึกอบรม',
                                'rating_qa'            => '5. ตอบข้อซักถาม ข้อสงสัยผู้เข้ารับการอบรมได้อย่างครบถ้วนเป็นที่เข้าใจ',
                                'rating_media'         => '6. มีการใช้สื่ออุปกรณ์การสอนเหมาะสมกับเนื้อหาสาระของแต่ละหัวข้อวิชา',
                                'rating_documents'     => '7. เอกสารประกอบการบรรยายมีอย่างเพียงพอเหมาะสมกับจำนวนผู้เข้ารับการอบรม',
                            ];
                        @endphp

                        @foreach($criteria as $key => $label)
                            <div class="space-y-4 p-5 bg-slate-50/60 rounded-2xl border border-slate-100" x-data="{ rating: {{ old($key, 0) }} }">
                                <label class="text-sm font-bold text-slate-700 leading-relaxed block">{{ $label }} <span class="text-error">*</span></label>
                                <div class="flex gap-2 flex-wrap">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="{{ $key }}" value="{{ $i }}" x-model="rating" class="hidden">
                                            <div :class="rating >= {{ $i }} ? 'bg-primary text-white shadow-md shadow-primary/20 scale-110' : 'bg-white text-text-disabled hover:bg-slate-100 border border-slate-200'"
                                                class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-200 transform active:scale-90 flex-shrink-0">
                                                <span class="font-bold">{{ $i }}</span>
                                            </div>
                                        </label>
                                    @endfor
                                    <span class="ml-2 self-center text-xs text-slate-400 font-bold" x-text="rating > 0 ? rating + ' / 5' : 'ยังไม่ได้เลือก'"></span>
                                </div>
                                @error($key) <span class="text-error text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        @endforeach

                        {{-- ส่วนที่ 2: ปัญหาและข้อเสนอแนะ --}}
                        <div class="pt-4 border-t border-slate-100 space-y-6">
                            <div>
                                <h3 class="text-base font-black text-slate-800 tracking-tight">ส่วนที่ 2 – ปัญหาและข้อเสนอแนะเพื่อการปรับปรุง</h3>
                                <p class="text-xs text-slate-400 font-bold mt-0.5">แสดงความคิดเห็น หรือข้อเสนอแนะเพิ่มเติม (ถ้ามี)</p>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-600 block">ปัญหาและข้อเสนอแนะ</label>
                                <textarea name="problems_suggestions" rows="4"
                                    placeholder="กรอกปัญหาหรือข้อเสนอแนะเพื่อการปรับปรุง..."
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-[1.5rem] focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-text-disabled font-medium">{{ old('problems_suggestions') }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-600 block">ข้อเสนอแนะอื่นๆ (ทั่วไป)</label>
                                <textarea name="comment" rows="3"
                                    placeholder="แสดงความคิดเห็นอื่นๆ..."
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-[1.5rem] focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-text-disabled font-medium">{{ old('comment') }}</textarea>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full py-5 bg-slate-900 text-white font-bold rounded-[2rem] hover:bg-black transition-all shadow-xl shadow-slate-900/15 transform active:scale-95 flex items-center justify-center gap-3">
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
</x-layouts.student>
