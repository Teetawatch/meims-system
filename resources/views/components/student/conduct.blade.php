<div class="p-8 md:p-12">

        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">คะแนนความประพฤติ</h1>
                <p class="text-slate-500 font-medium mt-1">ตรวจสอบประวัติการตัด/บวกคะแนนความประพฤติ</p>
            </div>

            <div class="flex gap-4">
                <div class="bg-white rounded-[2rem] px-8 py-4 shadow-sm border border-slate-100 text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">คะแนนคงเหลือ</p>
                    <h4 class="text-4xl font-black text-orange-500">{{ $student->total_conduct_score }}</h4>
                </div>
            </div>
        </header>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">ประวัติรายการ</h3>
            </div>

            <div class="p-8">
                @forelse($scores as $score)
                    <div
                        class="flex items-center gap-8 p-6 rounded-[2rem] hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group mb-4 last:mb-0">
                        <div
                            class="w-16 h-16 rounded-2xl flex items-center justify-center font-black group-hover:scale-110 transition-transform {{ $score->score > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                            <span class="text-xl">{{ $score->score > 0 ? '+' : '' }}{{ $score->score }}</span>
                        </div>

                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-slate-800">{{ $score->description }}</h4>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">บันทึกโดย:
                                {{ $score->recorded_by ?? 'ระบบอัตโนมัติ' }}</p>
                        </div>

                        <div class="text-right">
                            <div class="text-sm font-black text-slate-400 uppercase tracking-widest">
                                {{ $score->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-slate-300">{{ $score->created_at->format('H:i') }} น.</div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center">
                        <p class="text-slate-400 font-medium italic">ยังไม่มีรายการประวัติความประพฤติ</p>
                    </div>
                @endforelse
            </div>
        </div>
</div>