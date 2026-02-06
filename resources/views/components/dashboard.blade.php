<div x-data="{ sidebarOpen: false }" @open-sidebar.window="sidebarOpen = true"
    class="flex min-h-screen bg-slate-50 font-['Outfit','Anuphan'] relative">
    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 lg:hidden"></div>

    <!-- Sidebar Container -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="w-72 bg-white/95 backdrop-blur-2xl border-r border-slate-200 flex flex-col fixed inset-y-0 left-0 z-40 transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">
        <x-sidebar />
    </aside>

    <!-- Main Content Outer Container -->
    <div class="flex-1 lg:ml-72 min-h-screen flex flex-col">
        <main class="flex-1 p-4 md:p-8 relative">
            <!-- Aurora Background Decoration -->
            <div
                class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-blue-100/50 rounded-full blur-[80px] md:blur-[100px] -mr-32 md:-mr-64 -mt-32 md:-mt-64 pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-indigo-100/40 rounded-full blur-[80px] md:blur-[100px] -ml-24 md:-ml-48 -mb-24 md:-mb-48 pointer-events-none">
            </div>

            <!-- Header -->
            <header
                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 md:mb-12 relative z-10">
                <div class="flex items-center justify-between w-full md:w-auto">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-black text-slate-900">แดชบอร์ดระบบ</h1>
                        <p class="text-slate-500 font-bold text-[10px] md:text-xs mt-1">ศูนย์ควบคุม MEIMS • ภาพรวมระบบ
                        </p>
                    </div>

                    <!-- Mobile Menu Toggle Button -->
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-3 bg-white text-slate-600 rounded-2xl shadow-sm border border-slate-100 active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 no-scrollbar">
                    <div
                        class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3 shrink-0">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-[10px] md:text-xs font-black text-slate-600">เครื่องแม่ข่ายปกติ</span>
                    </div>
                    <button
                        class="p-3 bg-white text-slate-400 hover:text-slate-900 rounded-2xl shadow-sm border border-slate-100 transition-all hover:border-slate-300 active:scale-95 group shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:rotate-12 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Bento Grid Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12 relative z-10">
                <!-- Total Students -->
                <div
                    class="bg-slate-900 p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] text-white shadow-2xl shadow-slate-900/20 group overflow-hidden relative">
                    <div
                        class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-blue-50/10 transition-colors duration-700">
                    </div>
                    <div class="flex items-center gap-4 mb-4 md:mb-6 relative z-10">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-[10px] md:text-xs font-black opacity-50 mb-1">นักเรียนทั้งหมด</h3>
                    <p class="text-3xl md:text-4xl font-black tabular-nums">
                        {{ number_format($stats['total_students']) }}</p>
                    <p class="text-[10px] font-bold text-blue-400 mt-2">ทะเบียนรายชื่อปัจจุบัน</p>
                </div>

                <!-- Total Courses -->
                <div
                    class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.04)] border border-slate-100 group transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-4 md:mb-6">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-[10px] md:text-xs font-black text-slate-400 mb-1">หลักสูตรที่เปิดสอน</h3>
                    <p class="text-3xl md:text-4xl font-black text-slate-900 tabular-nums">
                        {{ number_format($stats['total_courses']) }}</p>
                    <p class="text-[10px] font-bold text-indigo-500 mt-2">โปรแกรมวิชาการ</p>
                </div>

                <!-- Total Subjects -->
                <div
                    class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.04)] border border-slate-100 group transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-4 md:mb-6">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.247 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-[10px] md:text-xs font-black text-slate-400 mb-1">รายวิชาทั้งหมด</h3>
                    <p class="text-3xl md:text-4xl font-black text-slate-900 tabular-nums">
                        {{ number_format($stats['total_subjects']) }}</p>
                    <p class="text-[10px] font-bold text-pink-500 mt-2">คลังวิชาการ</p>
                </div>

                <!-- Total Teachers -->
                <div
                    class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.04)] border border-slate-100 group transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-4 md:mb-6">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-[10px] md:text-xs font-black text-slate-400 mb-1">อาจารย์ผู้สอน</h3>
                    <p class="text-3xl md:text-4xl font-black text-slate-900 tabular-nums">
                        {{ number_format($stats['total_teachers']) }}</p>
                    <p class="text-[10px] font-bold text-orange-500 mt-2">คณะอาจารย์</p>
                </div>
            </div>

            <!-- Recent Activities Box -->
            <div
                class="bg-white rounded-[2rem] md:rounded-[3.5rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.04)] border border-slate-100 p-6 md:p-10 relative z-10 overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none group-hover:bg-blue-50/50 transition-colors duration-1000">
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 md:mb-10">
                    <h3 class="text-xl md:text-2xl font-black text-slate-900 flex items-center gap-3">
                        ลงทะเบียนล่าสุด
                        <span
                            class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg">รายการใหม่</span>
                    </h3>
                    <a href="{{ route('students.index') }}"
                        class="text-blue-600 font-black text-[10px] md:text-xs hover:text-blue-800 transition-colors">ดูนักเรียนทั้งหมด</a>
                </div>

                <div class="overflow-x-auto -mx-6 md:mx-0 px-6 md:px-0">
                    <table class="w-full text-left min-w-[600px] md:min-w-full">
                        <thead>
                            <tr class="text-[10px] md:text-xs font-black text-slate-400 border-b border-slate-50">
                                <th class="pb-6 pl-4">ข้อมูลนักเรียน</th>
                                <th class="pb-6">รหัสประจำตัว</th>
                                <th class="pb-6">รุ่น / สังกัด</th>
                                <th class="pb-6">วันที่บันทึก</th>
                                <th class="pb-6 text-right pr-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentStudents as $student)
                                <tr class="group/row hover:bg-slate-50 transition-all duration-300">
                                    <td class="py-4 md:py-6 pl-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 md:w-12 md:h-12 bg-slate-100 rounded-xl md:rounded-2xl flex items-center justify-center text-slate-400 group-hover/row:bg-blue-600 group-hover/row:text-white transition-all duration-500 overflow-hidden shrink-0">
                                                @if($student->photo_path)
                                                    <img src="{{ asset('storage/' . $student->photo_path) }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <span
                                                        class="font-black text-sm">{{ mb_substr($student->first_name_th, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-sm font-black text-slate-900 truncate">
                                                    {{ $student->title_th }}{{ $student->first_name_th }}
                                                    {{ $student->last_name_th }}</div>
                                                <div class="text-[10px] font-bold text-slate-400 capitalize truncate">
                                                    {{ $student->first_name_en }} {{ $student->last_name_en }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 md:py-6">
                                        <span
                                            class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] md:text-xs font-black text-slate-600 group-hover/row:bg-white transition-colors">{{ $student->student_id }}</span>
                                    </td>
                                    <td class="py-4 md:py-6">
                                        <div class="text-[13px] md:text-sm font-bold text-slate-600">รุ่น
                                            {{ $student->batch }}</div>
                                        <div class="text-[10px] font-medium text-slate-400 truncate">
                                            {{ $student->course->course_name_th ?? 'ภาคปกติ' }}</div>
                                    </td>
                                    <td class="py-4 md:py-6">
                                        <div class="text-[13px] md:text-sm font-bold text-slate-600">
                                            {{ $student->created_at ? $student->created_at->format('d/m/Y') : '-' }}</div>
                                        <div
                                            class="text-[10px] font-medium text-slate-400 opacity-0 group-hover/row:opacity-100 transition-opacity">
                                            เวลา {{ $student->created_at ? $student->created_at->format('H:i') : '' }} น.
                                        </div>
                                    </td>
                                    <td class="py-4 md:py-6 text-right pr-4">
                                        <a href="{{ route('students.index', ['search' => $student->student_id]) }}"
                                            class="inline-flex py-2 px-3 md:px-4 bg-white border border-slate-100 rounded-xl text-[10px] font-black uppercase text-slate-400 hover:text-blue-600 hover:border-blue-500 hover:shadow-lg hover:shadow-blue-500/10 transition-all active:scale-95">
                                            <span class="hidden sm:inline">รายบุคคล</span>
                                            <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 font-bold text-xs capitalize">
                                                ยังไม่มีรายการล่าสุดในขณะนี้</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <style>
        @media (max-width: 640px) {
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        }
    </style>
</div>