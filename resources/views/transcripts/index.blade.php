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
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">ใบรับรองผลการเกรด (Transcript)</h1>
                <p class="text-slate-500 font-medium">พิมพ์ใบรับรองผลการเกรดแยกตามหลักสูตร รุ่น หรือรายบุคคล</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('transcripts.download', ['course_id' => $courseFilter, 'batch' => $batchFilter, 'fiscal_year' => $yearFilter]) }}"
                    target="_blank"
                    class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 transform active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    พิมพ์ทั้งหมดตามตัวกรอง
                </a>
            </div>
        </header>

        <!-- Filters Section -->
        <div class="bg-surface p-6 rounded-2xl shadow-card border border-border mb-8">
            <form action="{{ route('transcripts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" x-data="{ submitForm() { this.$el.closest('form').submit() } }">
                <div class="lg:col-span-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block ml-1">ค้นหานักเรียน (กด Enter)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}" placeholder="ชื่อ, รหัสนักเรียน..."
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block ml-1">หลักสูตร</label>
                    <select name="courseFilter" @change="submitForm"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 outline-none transition-all">
                        <option value="">ทั้งหมด</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $courseFilter == $course->id ? 'selected' : '' }}>{{ $course->course_code }} - {{ $course->course_name_th }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block ml-1">รุ่น</label>
                    <select name="batchFilter" @change="submitForm"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 outline-none transition-all">
                        <option value="">ทั้งหมด</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch }}" {{ $batchFilter == $batch ? 'selected' : '' }}>{{ $batch }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block ml-1">ปีงบประมาณ</label>
                    <select name="yearFilter" @change="submitForm"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 outline-none transition-all">
                        <option value="">ทั้งหมด</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ $yearFilter == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Student List -->
        <div class="bg-surface rounded-2xl shadow-card border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">นักเรียน</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">หลักสูตร / รุ่น</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($students as $student)
                            <tr class="hover:bg-surface-hover transition-colors duration-200 group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 font-bold text-sm">
                                            {{ mb_substr($student->first_name_th, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">
                                                {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}
                                            </div>
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                {{ $student->student_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm font-bold text-slate-700">
                                        {{ $student->course->course_name_th ?? '-' }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">รุ่น:
                                        {{ $student->batch }} | ปี: {{ $student->fiscal_year }}</div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('transcripts.download', ['student_id' => $student->id]) }}"
                                        target="_blank"
                                        class="inline-flex items-center px-4 py-3 bg-slate-50 text-slate-600 hover:bg-indigo-600 hover:text-white text-xs font-bold rounded-xl transition-all group-hover:shadow-md">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        พิมพ์ PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center text-slate-400 font-bold">ไม่พบข้อมูลนักเรียน
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($students->hasPages())
                <div class="px-8 py-6 bg-slate-50/50 border-t border-border">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </main>
</div>
</x-layouts.app>
