<div class="min-h-screen flex bg-slate-50 font-['Outfit','Anuphan']">

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out both; }
        .animate-fade-in-1 { animation: fadeIn 0.5s ease-out 0.08s both; }
        .animate-fade-in-2 { animation: fadeIn 0.5s ease-out 0.16s both; }
        .animate-fade-in-3 { animation: fadeIn 0.5s ease-out 0.24s both; }
    </style>

    <!-- Sidebar -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-guardian-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-6 md:p-8 lg:p-10 overflow-y-auto">

        <!-- Student Header Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 mb-8 animate-fade-in">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-24 h-24 rounded-2xl overflow-hidden border-4 border-slate-100 shrink-0 shadow-lg">
                    @if($student->photo_path)
                        <img src="{{ asset('storage/' . $student->photo_path) }}" alt="รูปภาพ" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-700 flex items-center justify-center text-white text-3xl font-bold">
                            {{ mb_substr($student->first_name_th, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="text-center md:text-left flex-1">
                    <a href="{{ route('guardian.dashboard') }}" class="text-teal-600 text-xs font-semibold hover:text-teal-700 transition-colors inline-flex items-center gap-1 mb-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        กลับหน้าหลัก
                    </a>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800 leading-tight">
                        {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}
                    </h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-2">
                        <span class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium">
                            {{ $student->student_id }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium">
                            {{ $student->course->course_name_th ?? $student->course_name }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium">
                            รุ่น {{ $student->batch }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-1">
            <!-- Personal Info -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    ข้อมูลส่วนตัว
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-400">วันเกิด</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $student->birth_date ? $student->birth_date->format('d/m/') . ($student->birth_date->year + 543) : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-400">เบอร์โทร</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $student->phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-400">อีเมล</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $student->email ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-400">ปีงบประมาณ</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $student->fiscal_year ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Conduct Score -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    คะแนนความประพฤติ
                </h3>
                @php
                    $totalConduct = 100 + $student->conductScores->sum('score');
                @endphp
                <div class="text-center pt-2">
                    <div class="text-5xl font-black mb-2 {{ $totalConduct >= 80 ? 'text-emerald-600' : ($totalConduct >= 60 ? 'text-amber-600' : 'text-red-600') }}">
                        {{ $totalConduct }}
                    </div>
                    <p class="text-xs text-slate-400 mb-4">คะแนน (จาก 100)</p>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 {{ $totalConduct >= 80 ? 'bg-emerald-500' : ($totalConduct >= 60 ? 'bg-amber-500' : 'bg-red-500') }}"
                            style="width: {{ min($totalConduct, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- GPA -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    เกรดเฉลี่ย
                </h3>
                <div class="text-center pt-2">
                    <div class="text-5xl font-black text-blue-600 mb-2">
                        {{ number_format($student->gpa_y1_t2 ?? $student->gpa_y1_t1 ?? 0, 2) }}
                    </div>
                    <p class="text-xs text-slate-400">จาก 4.00</p>
                </div>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-8 animate-fade-in-2">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="font-bold text-slate-800">ผลการเรียน</h3>
                <span class="ml-auto text-xs font-semibold text-slate-400">{{ $grades->count() }} วิชา</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">รหัสวิชา</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">ชื่อวิชา</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">หน่วยกิต</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">เกรด</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($grades as $gradeRecord)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-700 text-sm">{{ $gradeRecord->subject->subject_code }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 text-sm">{{ $gradeRecord->subject->subject_name_th }}</div>
                                    <div class="text-xs text-slate-400">{{ $gradeRecord->subject->subject_name_en }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                        {{ $gradeRecord->subject->credits }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
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
                                        <span class="text-lg font-bold {{ $gradeColor }}">{{ $gradeRecord->grade }}</span>
                                    @else
                                        <span class="text-sm text-slate-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($gradeRecord->grade !== null)
                                        @if(floatval($gradeRecord->grade) >= 1)
                                            <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-lg">ผ่าน</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-lg">ไม่ผ่าน</span>
                                        @endif
                                    @else
                                        <span class="text-xs text-slate-300 italic">รอผล</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <p class="text-slate-400 text-sm">ยังไม่มีข้อมูลผลการเรียน</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Conduct History -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm animate-fade-in-3">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="font-bold text-slate-800">ประวัติความประพฤติ (ล่าสุด)</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">วันที่</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">รายละเอียด</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">คะแนน</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($conductScores as $conduct)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $conduct->created_at->format('d/m/') }}{{ $conduct->created_at->year + 543 }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700 font-medium">
                                    {{ $conduct->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-bold {{ $conduct->score >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                        {{ $conduct->score >= 0 ? '+' : '' }}{{ $conduct->score }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center">
                                    <p class="text-slate-400 text-sm">ยังไม่มีประวัติความประพฤติ</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
