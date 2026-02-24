<x-layouts.app>
<div class="min-h-screen bg-background font-body flex">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-text">รายงานข้อมูลนักเรียน</h1>
                <p class="text-text-muted text-sm font-medium">เรียกดูและส่งออกข้อมูลนักเรียนตามเงื่อนไข</p>
            </div>

            <form action="{{ route('reports.students.export') }}" method="POST">
                @csrf
                <input type="hidden" name="fiscal_year" value="{{ $fiscal_year }}">
                <input type="hidden" name="batch" value="{{ $batch }}">
                <input type="hidden" name="course_name" value="{{ $course_name }}">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    ส่งออก Excel
                </button>
            </form>
        </header>

        <!-- Filters -->
        <div class="bg-surface rounded-2xl p-6 shadow-card border border-border mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                ตัวกรองข้อมูล
            </h2>
            <form action="{{ route('reports.students') }}" method="GET" x-data="{ submitForm() { this.$el.closest('form').submit() } }">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">ปีงบประมาณ</label>
                        <select name="fiscal_year" @change="submitForm"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                            <option value="">ทั้งหมด</option>
                            @foreach($fiscal_years as $fy)
                                <option value="{{ $fy }}" {{ $fiscal_year == $fy ? 'selected' : '' }}>{{ $fy }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">รุ่น</label>
                        <select name="batch" @change="submitForm"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                            <option value="">ทั้งหมด</option>
                            @foreach($batches as $b)
                                <option value="{{ $b }}" {{ $batch == $b ? 'selected' : '' }}>รุ่น {{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">หลักสูตร</label>
                        <select name="course_name" @change="submitForm"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                            <option value="">ทั้งหมด</option>
                            @foreach($courses as $c)
                                <option value="{{ $c }}" {{ $course_name == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('reports.students') }}" class="text-sm text-slate-500 hover:text-slate-800 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        ล้างตัวกรอง
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-surface rounded-2xl shadow-card border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-hover/50">
                        <tr class="text-text-muted text-xs font-semibold uppercase tracking-wider border-b border-border">
                            <th class="px-6 py-4">รหัสนักเรียน</th>
                            <th class="px-6 py-4">ชื่อ - สกุล</th>
                            <th class="px-6 py-4">หลักสูตร</th>
                            <th class="px-6 py-4">รุ่น</th>
                            <th class="px-6 py-4">ปีงบประมาณ</th>
                            <th class="px-6 py-4">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($students as $student)
                            <tr class="group hover:bg-surface-hover transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-text-secondary text-sm">{{ $student->student_id }}</td>
                                <td class="px-6 py-4 text-text font-medium text-sm">
                                    {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}
                                </td>
                                <td class="px-6 py-4 text-text-muted text-sm font-medium">{{ $student->course_name }}</td>
                                <td class="px-6 py-4 text-text-muted text-sm font-medium">{{ $student->batch }}</td>
                                <td class="px-6 py-4 text-text-muted text-sm font-medium">{{ $student->fiscal_year }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-success-light text-success px-2.5 py-1 rounded-lg text-xs font-semibold">ปกติ</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p>ไม่พบข้อมูลตามเงื่อนไขที่กำหนด</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-border">
                {{ $students->links() }}
            </div>
        </div>
    </main>
</div>
</x-layouts.app>
