<div class="min-h-screen flex bg-slate-50">
    <aside
        class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10">
            <a href="{{ route('student.surveys') }}"
                class="inline-flex items-center text-slate-400 hover:text-slate-600 mb-4 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                ย้อนกลับ
            </a>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ $survey->title }}</h1>
            <p class="text-slate-500 font-medium mt-1">{{ $survey->description }}</p>
        </header>

        <form wire:submit.prevent="save" class="max-w-4xl mx-auto space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100">
                <div class="space-y-12">
                    @foreach($survey->questions as $index => $question)
                        <div class="animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                            <h3 class="font-bold text-lg text-slate-800 mb-4">{{ $loop->iteration }}.
                                {{ $question->question_text }}
                            </h3>

                            <div class="grid grid-cols-5 gap-2 md:gap-4">
                                @foreach(range(1, 5) as $score)
                                    <label class="cursor-pointer group">
                                        <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $score }}"
                                            class="peer hidden">
                                        <div
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-slate-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-slate-50 transition-all">
                                            <span
                                                class="text-xl font-black text-slate-300 peer-checked:text-blue-600 group-hover:text-slate-400 mb-1">{{ $score }}</span>
                                            <span
                                                class="text-[10px] font-bold text-slate-400 peer-checked:text-blue-500 uppercase tracking-wider">
                                                @if($score == 1) ปรับปรุง @elseif($score == 5) ดีมาก @endif
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('answers.' . $question->id) <span
                            class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-8 border-t border-slate-100">
                    <label class="block font-bold text-lg text-slate-800 mb-4">ความคิดเห็นเพิ่มเติม / ข้อเสนอแนะ</label>
                    <textarea wire:model="comment" rows="4"
                        class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-slate-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all outline-none resize-none placeholder-slate-400"
                        placeholder="เขียนความคิดเห็นของคุณที่นี่..."></textarea>
                    @error('comment') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pb-20">
                <button type="submit"
                    class="px-10 py-4 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 transform hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    ส่งแบบประเมิน
                </button>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('survey-completed', () => {
                Swal.fire({
                    title: 'ขอบคุณ!',
                    text: 'บันทึกแบบสอบถามเรียบร้อยแล้ว',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#3B82F6',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = "{{ route('student.surveys') }}";
                });
            });
        });
    </script>
</div>