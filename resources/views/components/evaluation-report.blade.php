<div class="min-h-screen bg-slate-50 font-['Outfit','Anuphan'] flex">
    <x-sidebar />

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">สรุปผลการประเมิน</h1>
                <p class="text-slate-500 font-medium">รายงานสรุปคะแนนประเมินอาจารย์และเพื่อนร่วมห้อง</p>
            </div>

            <div class="flex bg-white p-1 rounded-2xl shadow-sm border border-slate-100">
                <button wire:click="$set('type', 'teacher')"
                    class="px-6 py-2 rounded-xl text-sm font-black transition-all {{ $type == 'teacher' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/10' : 'text-slate-400 hover:text-slate-600' }}">
                    อาจารย์
                </button>
                <button wire:click="$set('type', 'peer')"
                    class="px-6 py-2 rounded-xl text-sm font-black transition-all {{ $type == 'peer' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/10' : 'text-slate-400 hover:text-slate-600' }}">
                    เพื่อนร่วมห้อง
                </button>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-indigo-500/20">
                <p class="text-xs font-black uppercase tracking-widest opacity-60 mb-1">จำนวนการประเมินทั้งหมด</p>
                <h3 class="text-4xl font-black">
                    {{ $reportData->sum('evaluations_count') ?? $reportData->sum('evaluations_count') }} ครั้ง</h3>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">คะแนนเฉลี่ยรวม</p>
                <h3 class="text-4xl font-black text-slate-800">{{ number_format($reportData->avg('overall_avg'), 2) }} /
                    5.00</h3>
            </div>
        </div>

        <!-- Report Table -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                {{ $type == 'teacher' ? 'อาจารย์' : 'นักเรียน' }}
                            </th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                จำนวนผู้ประเมิน</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                คะแนนเฉลี่ย</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                                รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($reportData as $data)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 {{ $type == 'teacher' ? 'bg-blue-50 text-blue-600' : 'bg-indigo-50 text-indigo-600' }} rounded-xl flex items-center justify-center font-black text-xs">
                                            {{ mb_substr($data->first_name_th, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">
                                                {{ $data->title_th }}{{ $data->first_name_th }} {{ $data->last_name_th }}
                                            </div>
                                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                {{ $type == 'teacher' ? $data->teacher_code : $data->student_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span
                                        class="px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">{{ $data->evaluations_count }}
                                        คน</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="text-sm font-black text-slate-800">
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
                                        class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
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