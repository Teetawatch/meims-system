<div class="min-h-screen flex bg-slate-50">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">ผลการเรียน</h1>
                <p class="text-slate-500 font-medium mt-1">สรุปเกรดเฉลี่ยและประวัติผลการเรียนรายวิชา</p>
            </div>

            <div class="flex gap-4">
                <div class="bg-white rounded-[2rem] px-8 py-4 shadow-sm border border-slate-100 text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">GPA รวม</p>
                    <h4 class="text-3xl font-black text-blue-600">
                        {{ number_format($student->gpa_y1_t2 ?? $student->gpa_y1_t1, 2) }}</h4>
                </div>
            </div>
        </header>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 bg-slate-50/50 border-b border-slate-100 items-center justify-between flex">
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">ประวัติการเรียนภาคเรียนปัจจุบัน
                </h3>
                <span class="text-xs font-bold text-slate-400 bg-slate-200/50 px-3 py-1 rounded-full">ปีการศึกษา
                    2567</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/30">
                        <tr
                            class="text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                            <th class="px-8 py-5">รหัสวิชา</th>
                            <th class="px-8 py-5">ชื่อวิชา</th>
                            <th class="px-8 py-5 text-center">หน่วยกิต</th>
                            <th class="px-8 py-5 text-center text-blue-600">เกรด</th>
                            <th class="px-8 py-5 text-right">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php
                            $studentGrades = \App\Models\Grade::where('student_id', $student->id)
                                ->with('subject')
                                ->latest()
                                ->get();
                        @endphp

                        @forelse($studentGrades as $gradeRecord)
                            <tr class="group hover:bg-slate-50/50 transition-all">
                                <td class="px-8 py-6">
                                    <span class="font-black text-slate-700">{{ $gradeRecord->subject->subject_code }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-bold text-slate-800">{{ $gradeRecord->subject->subject_name_th }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium capitalize">
                                        {{ $gradeRecord->subject->subject_name_en }}</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600 ring-1 ring-slate-400/10">
                                        {{ $gradeRecord->subject->credits }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @if($gradeRecord->grade !== null)
                                        @php
                                            $gVal = floatval($gradeRecord->grade);
                                            $gradeColor = match(true) {
                                                $gVal >= 3 => 'text-emerald-600',
                                                $gVal >= 2 => 'text-blue-600',
                                                $gVal >= 1 => 'text-amber-600',
                                                default => 'text-red-500',
                                            };
                                        @endphp
                                        <span class="text-lg font-black {{ $gradeColor }}">
                                            {{ $gradeRecord->grade }}
                                        </span>
                                    @else
                                        <span class="text-sm text-slate-300 font-medium">-</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if($gradeRecord->grade !== null)
                                        @if(floatval($gradeRecord->grade) >= 1)
                                            <span class="text-xs text-emerald-500 font-semibold">ผ่าน</span>
                                        @else
                                            <span class="text-xs text-red-500 font-semibold">ไม่ผ่าน</span>
                                        @endif
                                    @else
                                        <span class="text-xs text-slate-300 font-medium italic">รอผล</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <p class="text-slate-400 font-medium italic">ยังไม่พบข้อมูลผลการเรียน</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>