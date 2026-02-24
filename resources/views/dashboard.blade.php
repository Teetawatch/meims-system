<x-layouts.app>
<div x-data="{ sidebarOpen: false }" @open-sidebar.window="sidebarOpen = true"
    class="flex min-h-screen bg-[#F8FAFC] font-body text-slate-800 relative overflow-hidden">
    
    <!-- Premium Aurora Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-gradient-to-br from-blue-400/30 to-indigo-500/20 rounded-full blur-[100px] animate-blob mix-blend-multiply"></div>
        <div class="absolute top-[40%] left-[-10%] w-[500px] h-[500px] bg-gradient-to-tr from-purple-400/30 to-pink-400/20 rounded-full blur-[100px] animate-blob animation-delay-2000 mix-blend-multiply"></div>
        <div class="absolute bottom-[-10%] right-[15%] w-[700px] h-[700px] bg-gradient-to-bl from-cyan-400/30 to-blue-500/20 rounded-full blur-[120px] animate-blob animation-delay-4000 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-white/40 backdrop-blur-[2px]"></div>
    </div>

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity.duration.300ms @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="w-72 shrink-0 bg-white/70 backdrop-blur-2xl border-r border-white/60 shadow-[4px_0_24px_-12px_rgba(0,0,0,0.1)] flex flex-col fixed inset-y-0 left-0 z-50 transition-transform duration-500 ease-out">
        <x-sidebar />
    </aside>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-72 flex flex-col min-h-screen relative z-10 transition-all duration-300">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-30 bg-white/60 backdrop-blur-xl border-b border-white/40 shadow-sm supports-[backdrop-filter]:bg-white/40 px-6 lg:px-10 py-4 flex items-center justify-between transition-all">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true"
                    class="lg:hidden p-2.5 bg-white/80 hover:bg-white text-slate-600 rounded-xl shadow-sm border border-slate-200/50 hover:shadow-md transition-all active:scale-95 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <div>
                    <h2 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-800 to-slate-600">แดชบอร์ดระบบ</h2>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-0.5">ศูนย์ควบคุม MEIMS — ภาพรวมระบบ</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-green-50/80 border border-green-100 rounded-xl shadow-sm backdrop-blur-md">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-bold text-green-700">เครื่องแม่ข่ายปกติ</span>
                </div>
                
                <button class="p-2.5 bg-white/80 hover:bg-white text-slate-500 hover:text-blue-600 rounded-xl shadow-sm border border-slate-200/50 hover:border-blue-200 hover:shadow-md transition-all active:scale-95 relative group">
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white shadow-sm"></span>
                    <svg class="w-5 h-5 group-hover:animate-wiggle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="flex-1 p-6 lg:p-10 space-y-8">
            
            <!-- Quick Stats Bento Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Primary Stat Card -->
                <div class="relative group bg-slate-900 rounded-[2rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgb(59,130,246,0.3)] transition-all duration-300 overflow-hidden cursor-pointer transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700 ease-out"></div>
                    
                    <div class="relative z-10 flex flex-col h-full justify-between gap-6">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/10 group-hover:rotate-12 transition-transform duration-300 shadow-inner">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm font-semibold text-slate-400 mb-1">นักเรียนทั้งหมด</p>
                            <h3 class="text-4xl font-black text-white tracking-tight tabular-nums">{{ number_format($stats['total_students']) }}</h3>
                            <p class="text-xs font-bold text-blue-400 mt-2">ทะเบียนรายชื่อปัจจุบัน</p>
                        </div>
                    </div>
                </div>

                <!-- Secondary Stat Cards -->
                @php
                    $secondaryStats = [
                        [
                            'label' => 'หลักสูตรที่เปิดสอน',
                            'value' => $stats['total_courses'],
                            'color' => 'indigo',
                            'trend' => 'โปรแกรมวิชาการ',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>'
                        ],
                        [
                            'label' => 'รายวิชาทั้งหมด',
                            'value' => $stats['total_subjects'],
                            'color' => 'pink',
                            'trend' => 'คลังวิชาการ',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.247 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>'
                        ],
                        [
                            'label' => 'อาจารย์ผู้สอน',
                            'value' => $stats['total_teachers'],
                            'color' => 'orange',
                            'trend' => 'คณะอาจารย์',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>'
                        ]
                    ];
                @endphp

                @foreach($secondaryStats as $stat)
                @php
                    $color = $stat['color'];
                    $bgColors = [
                        'indigo' => 'bg-indigo-50/50',
                        'pink' => 'bg-pink-50/50',
                        'orange' => 'bg-orange-50/50'
                    ];
                    $textColors = [
                        'indigo' => 'text-indigo-600',
                        'pink' => 'text-pink-600',
                        'orange' => 'text-orange-600'
                    ];
                    $iconBgs = [
                        'indigo' => 'bg-indigo-100/50',
                        'pink' => 'bg-pink-100/50',
                        'orange' => 'bg-orange-100/50'
                    ];
                @endphp
                <div class="group bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/60 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 {{ $bgColors[$color] }} rounded-full blur-xl group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    
                    <div class="relative z-10 flex flex-col h-full justify-between gap-6">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl {{ $iconBgs[$color] }} {{ $textColors[$color] }} shadow-sm flex items-center justify-center border border-white group-hover:rotate-12 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $stat['icon'] !!}
                                </svg>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm font-semibold text-slate-500 mb-1">{{ $stat['label'] }}</p>
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight tabular-nums">{{ number_format($stat['value']) }}</h3>
                            <p class="text-xs font-bold {{ $textColors[$color] }} mt-2">{{ $stat['trend'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Bottom Section Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Activities Table -->
                <div class="lg:col-span-2 bg-white/70 backdrop-blur-xl rounded-[2rem] border border-white/60 shadow-[0_4px_24px_-8px_rgba(0,0,0,0.05)] overflow-hidden relative">
                <!-- Decorative element -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>

                <div class="p-8 border-b border-slate-100/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            ลงทะเบียนล่าสุด
                            <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-lg ml-2">รายการใหม่</span>
                        </h2>
                        <p class="text-sm text-slate-500 font-medium mt-1">รายชื่อนักเรียนที่เพิ่งถูกเพิ่มเข้าสู่ระบบ</p>
                    </div>
                    <a href="{{ route('students.index') }}" class="group bg-slate-50 hover:bg-white text-slate-600 hover:text-blue-600 text-sm font-bold px-5 py-2.5 rounded-xl border border-slate-200/60 hover:border-blue-200 shadow-sm hover:shadow-md transition-all active:scale-95 flex items-center gap-2">
                        ดูทั้งหมด
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="overflow-x-auto relative z-10 px-4 pb-4 mt-4">
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead>
                            <tr>
                                <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100/50 bg-slate-50/50 rounded-tl-xl w-[35%]">ข้อมูลนักเรียน</th>
                                <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100/50 bg-slate-50/50 w-[20%]">รหัสประจำตัว</th>
                                <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100/50 bg-slate-50/50 w-[25%]">รุ่น / สังกัด</th>
                                <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100/50 bg-slate-50/50 w-[15%]">วันที่บันทึก</th>
                                <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100/50 bg-slate-50/50 text-right rounded-tr-xl w-[5%]">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/50">
                            @forelse($recentStudents as $student)
                            <tr class="group hover:bg-white hover:shadow-[0_4px_20px_-10px_rgba(0,0,0,0.08)] transition-all duration-300">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-black shadow-inner border border-white overflow-hidden shrink-0 group-hover:scale-105 group-hover:text-blue-600 transition-all duration-300">
                                            @if($student->photo_path)
                                                <img src="{{ asset('storage/' . $student->photo_path) }}" class="w-full h-full object-cover" alt="Profile">
                                            @else
                                                <span class="text-sm">{{ mb_substr($student->first_name_th, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 truncate">{{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</p>
                                            <p class="text-[11px] font-semibold text-slate-400 capitalize mt-0.5 truncate">{{ $student->first_name_en }} {{ $student->last_name_en }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[11px] font-bold rounded-lg border border-slate-200/50 group-hover:bg-blue-50 group-hover:text-blue-700 transition-colors">
                                        {{ $student->student_id }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-bold text-slate-700 truncate">รุ่น {{ $student->batch }}</p>
                                    </div>
                                    <p class="text-[11px] font-semibold text-slate-500 mt-0.5 truncate">{{ $student->course->course_name_th ?? 'ภาคปกติ' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm font-bold text-slate-700">{{ $student->created_at ? $student->created_at->format('d/m/Y') : '-' }}</p>
                                    <p class="text-[11px] font-semibold text-slate-400 mt-0.5 opacity-0 group-hover:opacity-100 transition-opacity">เวลา {{ $student->created_at ? $student->created_at->format('H:i') . ' น.' : '' }}</p>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('students.index', ['search' => $student->student_id]) }}" class="inline-flex items-center justify-center py-2 px-3 rounded-xl bg-slate-50 border border-slate-200/60 text-slate-500 text-[11px] font-bold hover:bg-white hover:text-blue-600 hover:border-blue-200 hover:shadow-sm transition-all shadow-sm">
                                        รายบุคคล
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 shadow-inner">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-bold text-sm">ยังไม่มีข้อมูลล่าสุด</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
            </div>

                <!-- Students by Course -->
                <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] border border-white/60 shadow-[0_4px_24px_-8px_rgba(0,0,0,0.05)] overflow-hidden relative p-8 flex flex-col">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50/50 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
                    
                    <div class="relative z-10 mb-8">
                        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            สัดส่วนนักเรียน
                        </h2>
                        <p class="text-sm text-slate-500 font-medium mt-1">แบ่งตามหลักสูตร (สูงสุด 5 อันดับแรก)</p>
                    </div>

                    <div class="flex-1 space-y-6 relative z-10">
                        @forelse($studentsByCourse as $courseData)
                        <div class="group cursor-default">
                            <div class="flex justify-between items-end mb-2">
                                <div class="w-[70%]">
                                    <p class="text-sm font-bold text-slate-700 truncate group-hover:text-indigo-600 transition-colors">{{ $courseData->course_name_th }}</p>
                                    <p class="text-[11px] font-semibold text-slate-400 truncate mt-0.5">{{ $courseData->course_code }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-base font-black text-slate-800 tabular-nums leading-none">{{ number_format($courseData->students_count) }}</p>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">คน</span>
                                </div>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden border border-slate-200/50">
                                @php
                                    $percentage = $stats['total_students'] > 0 ? ($courseData->students_count / $stats['total_students']) * 100 : 0;
                                @endphp
                                <div class="bg-gradient-to-r from-indigo-400 to-indigo-500 h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center h-full gap-3 py-10">
                            <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 shadow-inner">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-bold text-xs">ยังไม่มีข้อมูลนักเรียน</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </main>
    </div>
</div>

<style>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
    animation: blob 10s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.animation-delay-4000 {
    animation-delay: 4s;
}
@keyframes wiggle {
    0%, 100% { transform: rotate(-3deg); }
    50% { transform: rotate(3deg); }
}
.animate-wiggle {
    animation: wiggle 0.5s ease-in-out infinite;
}
</style>
</x-layouts.app>