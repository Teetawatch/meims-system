<div class="min-h-screen bg-slate-50 font-sans flex">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">รายงานข้อมูลนักเรียน</h1>
                <p class="text-slate-500">เรียกดูและส่งออกข้อมูลนักเรียนตามเงื่อนไข</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('reports.students.pdf', ['fiscal_year' => $fiscal_year, 'batch' => $batch, 'course_name' => $course_name]) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-red-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    ส่งออก PDF
                </a>
                <button wire:click="export"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-green-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    ส่งออก Excel
                </button>
            </div>
        </header>

        <!-- Filters -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                ตัวกรองข้อมูล
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label
                        class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">ปีงบประมาณ</label>
                    <select wire:model.live="fiscal_year"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        <option value="">ทั้งหมด</option>
                        @foreach($fiscal_years as $fy)
                            <option value="{{ $fy }}">{{ $fy }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">รุ่น</label>
                    <select wire:model.live="batch"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        <option value="">ทั้งหมด</option>
                        @foreach($batches as $b)
                            <option value="{{ $b }}">รุ่น {{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label
                        class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">หลักสูตร</label>
                    <select wire:model.live="course_name"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        <option value="">ทั้งหมด</option>
                        @foreach($courses as $c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button wire:click="resetFilters"
                    class="text-sm text-slate-500 hover:text-slate-800 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    ล้างตัวกรอง
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr
                            class="text-slate-500 text-sm font-semibold uppercase tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4">รหัสนักเรียน</th>
                            <th class="px-6 py-4">ชื่อ - สกุล</th>
                            <th class="px-6 py-4">หลักสูตร</th>
                            <th class="px-6 py-4">รุ่น</th>
                            <th class="px-6 py-4">ปีงบประมาณ</th>
                            <th class="px-6 py-4">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $student)
                            <tr class="group hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-700">{{ $student->student_id }}</td>
                                <td class="px-6 py-4 text-slate-600 font-medium">
                                    {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $student->course_name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $student->batch }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $student->fiscal_year }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-green-600/10">ปกติ</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
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
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $students->links() }}
            </div>
        </div>
    </main>
</div>