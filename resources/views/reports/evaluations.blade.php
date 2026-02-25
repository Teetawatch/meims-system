<x-layouts.app>
<div class="min-h-screen bg-background font-body flex">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">สรุปผลการประเมิน</h1>
                <p class="text-slate-500 font-medium">รายงานสรุปคะแนนประเมินอาจารย์และเพื่อนร่วมห้อง</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex bg-white p-1 rounded-2xl shadow-sm border border-slate-100">
                    <a href="{{ route('reports.evaluations', ['type' => 'teacher']) }}"
                        class="px-6 py-2 rounded-xl text-sm font-bold transition-all {{ $type == 'teacher' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/10' : 'text-slate-400 hover:text-slate-600' }}">
                        อาจารย์
                    </a>
                    <a href="{{ route('reports.evaluations', ['type' => 'peer']) }}"
                        class="px-6 py-2 rounded-xl text-sm font-bold transition-all {{ $type == 'peer' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/10' : 'text-slate-400 hover:text-slate-600' }}">
                        เพื่อนร่วมห้อง
                    </a>
                </div>
            </div>
        </header>

        <!-- Evaluation Toggle -->
        @php
            $isEnabled = $type == 'teacher' ? $teacherEvaluationEnabled : $peerEvaluationEnabled;
            $label = $type == 'teacher' ? 'อาจารย์' : 'เพื่อนร่วมห้อง';
        @endphp
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $isEnabled ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }} transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($type == 'teacher')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        @endif
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">เปิด/ปิด ระบบประเมิน{{ $label }}</h3>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">
                        @if($isEnabled)
                            <span class="text-emerald-600 font-bold">เปิดอยู่</span> — นักเรียนสามารถเข้าประเมิน{{ $label }}ได้
                        @else
                            <span class="text-red-500 font-bold">ปิดอยู่</span> — นักเรียนจะไม่เห็นส่วนประเมิน{{ $label }}
                        @endif
                    </p>
                </div>
            </div>
            <form action="{{ route('reports.evaluations.toggle') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="enabled" value="{{ $isEnabled ? '0' : '1' }}">
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all transform active:scale-95 shadow-sm {{ $isEnabled ? 'bg-red-50 text-red-600 hover:bg-red-100 border border-red-100' : 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-emerald-500/20' }}">
                    @if($isEnabled)
                        ปิดระบบประเมิน
                    @else
                        เปิดระบบประเมิน
                    @endif
                </button>
            </form>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-indigo-500/20">
                <p class="text-xs font-bold uppercase tracking-widest opacity-60 mb-1">จำนวนการประเมินทั้งหมด</p>
                <h3 class="text-4xl font-bold">
                    {{ $reportData->sum('evaluations_count') ?? 0 }} ครั้ง</h3>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">คะแนนเฉลี่ยรวม</p>
                <h3 class="text-4xl font-bold text-slate-800">{{ number_format($reportData->avg('overall_avg'), 2) }} /
                    5.00</h3>
            </div>
        </div>

        <!-- Report Table -->
        <div class="bg-surface rounded-2xl shadow-card border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th
                                class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                {{ $type == 'teacher' ? 'อาจารย์' : 'นักเรียน' }}
                            </th>
                            <th
                                class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                จำนวนผู้ประเมิน</th>
                            <th
                                class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                คะแนนเฉลี่ย</th>
                            <th
                                class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                                รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($reportData as $data)
                            <tr class="hover:bg-surface-hover transition-colors duration-200">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 {{ $type == 'teacher' ? 'bg-blue-50 text-blue-600' : 'bg-indigo-50 text-indigo-600' }} rounded-xl flex items-center justify-center font-bold text-xs">
                                            {{ mb_substr($data->first_name_th, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">
                                                {{ $data->title_th }}{{ $data->first_name_th }} {{ $data->last_name_th }}
                                            </div>
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                {{ $type == 'teacher' ? $data->teacher_code : $data->student_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span
                                        class="px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">{{ $data->evaluations_count ?? 0 }}
                                        คน</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="text-sm font-bold text-slate-800">
                                            {{ number_format($data->overall_avg, 2) }}</div>
                                        <div class="flex gap-0.5 mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <div
                                                    class="w-1.5 h-1.5 rounded-full {{ $data->overall_avg >= $i ? 'bg-amber-400' : 'bg-slate-200' }}">
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button
                                        class="p-2 text-text-muted cursor-pointer hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold">
                                    ยังไม่มีข้อมูลการประเมิน</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</x-layouts.app>
