<x-layouts.student title="คะแนนความประพฤติ">
<div class="min-h-screen flex bg-surface-hover">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-text tracking-tight">คะแนนความประพฤติ</h1>
                <p class="text-text-muted font-medium mt-1">ตรวจสอบประวัติการตัด/บวกคะแนนความประพฤติ</p>
            </div>

            <div class="flex gap-4">
                <div class="bg-surface rounded-2xl px-8 py-4 shadow-sm border border-border text-center">
                    <p class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-1">คะแนนคงเหลือ</p>
                    <h4 class="text-4xl font-bold text-orange-500">{{ $student->total_conduct_score }}</h4>
                </div>
            </div>
        </header>

        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            <div class="p-8 bg-slate-50/50 border-b border-border">
                <h3 class="text-xl font-bold text-text uppercase tracking-tight">ประวัติรายการ</h3>
            </div>

            <div class="p-8">
                @forelse($scores as $score)
                    <div
                        class="flex items-center gap-8 p-6 rounded-[2rem] hover:bg-surface-hover transition-all border border-transparent hover:border-border group mb-4 last:mb-0">
                        <div
                            class="w-16 h-16 rounded-2xl flex items-center justify-center font-bold group-hover:scale-110 transition-transform {{ $score->score > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-error-light text-red-600' }}">
                            <span class="text-xl">{{ $score->score > 0 ? '+' : '' }}{{ $score->score }}</span>
                        </div>

                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-text">{{ $score->description }}</h4>
                            <p class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mt-1">บันทึกโดย:
                                {{ $score->recorded_by ?? 'ระบบอัตโนมัติ' }}</p>
                        </div>

                        <div class="text-right">
                            <div class="text-sm font-bold text-text-disabled uppercase tracking-widest">
                                {{ $score->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-text-disabled">{{ $score->created_at->format('H:i') }} น.</div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center">
                        <p class="text-text-disabled font-medium italic">ยังไม่มีรายการประวัติความประพฤติ</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
</x-layouts.student>
