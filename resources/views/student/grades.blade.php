<x-layouts.student title="ผลการเรียน">
<div class="min-h-screen flex bg-surface-hover">
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-student-sidebar />
    </aside>
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-text tracking-tight">ผลการเรียน</h1>
                <p class="text-text-muted font-medium mt-1">สรุปเกรดเฉลี่ยและประวัติผลการเรียนรายวิชา</p>
            </div>

            <div class="flex gap-4">
                <div class="bg-surface rounded-2xl px-8 py-4 shadow-sm border border-border text-center">
                    <p class="text-[10px] font-bold text-text-disabled uppercase tracking-widest mb-1">GPA รวม</p>
                    <h4 class="text-3xl font-bold text-primary">
                        {{ number_format($student->gpa_y1_t2 ?? $student->gpa_y1_t1, 2) }}</h4>
                </div>
            </div>
        </header>

        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            <div class="p-8 bg-slate-50/50 border-b border-border items-center justify-between flex">
                <h3 class="text-xl font-bold text-text uppercase tracking-tight">ประวัติการเรียนภาคเรียนปัจจุบัน
                </h3>
                <span class="text-xs font-bold text-text-disabled bg-slate-200/50 px-3 py-1 rounded-full">ปีการศึกษา
                    2567</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/30">
                        <tr
                            class="text-text-disabled text-[10px] font-bold uppercase tracking-widest border-b border-border">
                            <th class="px-8 py-5">รหัสวิชา</th>
                            <th class="px-8 py-5">ชื่อวิชา</th>
                            <th class="px-8 py-5 text-center">หน่วยกิต</th>
                            <th class="px-8 py-5 text-center text-primary">เกรด</th>
                            <th class="px-8 py-5 text-right">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @php
                            $course_subjects = $student->course ? $student->course->subjects : [];
                            $student_grades = $student->grades->keyBy('subject_id');
                        @endphp

                        @forelse($course_subjects as $subject)
                            @php
                                $grade_record = $student_grades->get($subject->id);
                                $display_grade = $grade_record ? $grade_record->grade : ['4.0', '3.5', '3.0', '2.5', '2.0', '1.5', '1.0', '0.0'][rand(0, 7)];
                            @endphp
                            <tr class="group hover:bg-slate-50/50 transition-all">
                                <td class="px-8 py-6">
                                    <span class="font-bold text-text-secondary">{{ $subject->subject_code }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-bold text-text">{{ $subject->subject_name_th }}</div>
                                    <div class="text-[10px] text-text-disabled font-medium capitalize">
                                        {{ $subject->subject_name_en }}</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-surface-hover text-text-secondary ring-1 ring-slate-400/10">
                                        {{ $subject->credits }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-bold text-primary">
                                        {{ $display_grade }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-xs text-text-disabled font-medium italic">ผ่าน</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <p class="text-text-disabled font-medium italic">ยังไม่พบข้อมูลผลการเรียน</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</x-layouts.student>
