<x-layouts.student title="{{ $survey->title }}">
<div class="min-h-screen flex bg-surface-hover">
    <aside
        class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10">
            <a href="{{ route('student.surveys') }}"
                class="inline-flex items-center text-text-disabled hover:text-text-secondary mb-4 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                ย้อนกลับ
            </a>
            <h1 class="text-3xl font-bold text-text tracking-tight">{{ $survey->title }}</h1>
            <p class="text-text-muted font-medium mt-1">{{ $survey->description }}</p>
        </header>

        <form action="{{ route('student.surveys.store', $survey) }}" method="POST" class="max-w-4xl mx-auto space-y-8">
            @csrf
            <div class="bg-surface rounded-2xl p-8 md:p-12 shadow-sm border border-border">
                <div class="space-y-12">
                    @foreach($survey->questions as $index => $question)
                        <div class="animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                            <h3 class="font-bold text-lg text-text mb-4">{{ $loop->iteration }}.
                                {{ $question->question_text }}
                            </h3>

                            <div class="grid grid-cols-5 gap-2 md:gap-4">
                                @foreach(range(1, 5) as $score)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $score }}"
                                            class="peer hidden" {{ (old('answers.'.$question->id) == $score) ? 'checked' : '' }}>
                                        <div
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-border peer-checked:border-blue-500 peer-checked:bg-info-light hover:bg-surface-hover transition-all">
                                            <span
                                                class="text-xl font-bold text-text-disabled peer-checked:text-primary group-hover:text-text-disabled mb-1">{{ $score }}</span>
                                            <span
                                                class="text-[10px] font-bold text-text-disabled peer-checked:text-primary-light uppercase tracking-wider">
                                                @if($score == 1) ปรับปรุง @elseif($score == 5) ดีมาก @endif
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('answers.' . $question->id) <span
                            class="text-error text-sm mt-2 block">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-8 border-t border-border">
                    <label class="block font-bold text-lg text-text mb-4">ความคิดเห็นเพิ่มเติม / ข้อเสนอแนะ</label>
                    <textarea name="comment" rows="4"
                        class="w-full px-6 py-4 rounded-2xl bg-surface-hover border-2 border-border focus:border-primary focus:bg-white focus:ring-0 transition-all outline-none resize-none placeholder-slate-400"
                        placeholder="เขียนความคิดเห็นของคุณที่นี่...">{{ old('comment') }}</textarea>
                    @error('comment') <span class="text-error text-sm mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pb-20">
                <button type="submit"
                    class="px-10 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary-dark shadow-xl shadow-blue-500/20 transform hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    ส่งแบบประเมิน
                </button>
            </div>
        </form>
    </main>
</div>
</x-layouts.student>
