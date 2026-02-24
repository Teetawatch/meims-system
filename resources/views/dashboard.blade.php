<x-layouts.app>
<div x-data="{ sidebarOpen: false }" @open-sidebar.window="sidebarOpen = true"
    class="flex min-h-screen bg-background font-body relative">
    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 lg:hidden"></div>

    <!-- Sidebar Container -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="w-72 shrink-0 bg-surface backdrop-blur-2xl border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none">
        <x-sidebar />
    </aside>

    <!-- Main Content Outer Container -->
    <div class="flex-1 lg:ml-72 min-h-screen flex flex-col">
        <main class="flex-1 p-4 md:p-8 relative">
            <!-- Aurora Background Decoration (ui-ux-pro-max: subtle, non-distracting) -->
            <div
                class="absolute top-0 right-0 w-[300px] md:w-[450px] h-[300px] md:h-[450px] bg-blue-50/60 rounded-full blur-[80px] md:blur-[100px] -mr-32 md:-mr-48 -mt-32 md:-mt-48 pointer-events-none"
                aria-hidden="true">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[250px] md:w-[350px] h-[250px] md:h-[350px] bg-indigo-50/40 rounded-full blur-[80px] md:blur-[100px] -ml-24 md:-ml-32 -mb-24 md:-mb-32 pointer-events-none"
                aria-hidden="true">
            </div>

            <!-- Header -->
            <header
                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 md:mb-10 relative z-10">
                <div class="flex items-center justify-between w-full md:w-auto">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-text">แดชบอร์ดระบบ</h1>
                        <p class="text-text-muted font-medium text-xs mt-1">ศูนย์ควบคุม MEIMS — ภาพรวมระบบ</p>
                    </div>

                    <!-- Mobile Menu Toggle Button -->
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2.5 bg-surface text-text-secondary rounded-xl shadow-sm border border-border active:scale-95 transition-all duration-200 cursor-pointer hover:bg-surface-hover"
                        aria-label="เปิดเมนู">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 no-scrollbar">
                    <div
                        class="bg-surface px-4 py-2 rounded-xl shadow-sm border border-border flex items-center gap-2.5 shrink-0">
                        <div class="w-2 h-2 bg-success rounded-full animate-pulse"></div>
                        <span class="text-xs font-semibold text-text-secondary">เครื่องแม่ข่ายปกติ</span>
                    </div>
                    <button
                        class="p-2.5 bg-surface text-text-muted hover:text-text rounded-xl shadow-sm border border-border transition-all duration-200 hover:border-border-hover active:scale-95 group shrink-0 cursor-pointer"
                        aria-label="การแจ้งเตือน">
                        <svg class="w-5 h-5 transform group-hover:rotate-12 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Bento Grid Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-5 mb-8 md:mb-10 relative z-10">
                <!-- Total Students (Featured Card) -->
                <div
                    class="bg-gradient-to-br from-slate-900 to-slate-800 p-6 md:p-7 rounded-2xl text-white shadow-xl shadow-slate-900/15 group overflow-hidden relative cursor-pointer">
                    <div
                        class="absolute -right-4 -bottom-4 w-28 h-28 bg-white/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors duration-500"
                        aria-hidden="true">
                    </div>
                    <div class="flex items-center gap-3 mb-5 relative z-10">
                        <div
                            class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xs font-semibold opacity-50 mb-1 text-white">นักเรียนทั้งหมด</h3>
                    <p class="text-3xl md:text-4xl font-bold tabular-nums text-white">
                        {{ number_format($stats['total_students']) }}</p>
                    <p class="text-xs font-medium text-blue-400 mt-2">ทะเบียนรายชื่อปัจจุบัน</p>
                </div>

                <!-- Total Courses -->
                <div
                    class="card-hover p-6 md:p-7 cursor-pointer">
                    <div class="flex items-center gap-3 mb-5">
                        <div
                            class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xs font-semibold text-text-muted mb-1">หลักสูตรที่เปิดสอน</h3>
                    <p class="text-3xl md:text-4xl font-bold text-text tabular-nums">
                        {{ number_format($stats['total_courses']) }}</p>
                    <p class="text-xs font-medium text-indigo-500 mt-2">โปรแกรมวิชาการ</p>
                </div>

                <!-- Total Subjects -->
                <div
                    class="card-hover p-6 md:p-7 cursor-pointer">
                    <div class="flex items-center gap-3 mb-5">
                        <div
                            class="w-10 h-10 bg-pink-50 text-pink-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.247 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xs font-semibold text-text-muted mb-1">รายวิชาทั้งหมด</h3>
                    <p class="text-3xl md:text-4xl font-bold text-text tabular-nums">
                        {{ number_format($stats['total_subjects']) }}</p>
                    <p class="text-xs font-medium text-pink-500 mt-2">คลังวิชาการ</p>
                </div>

                <!-- Total Teachers -->
                <div
                    class="card-hover p-6 md:p-7 cursor-pointer">
                    <div class="flex items-center gap-3 mb-5">
                        <div
                            class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xs font-semibold text-text-muted mb-1">อาจารย์ผู้สอน</h3>
                    <p class="text-3xl md:text-4xl font-bold text-text tabular-nums">
                        {{ number_format($stats['total_teachers']) }}</p>
                    <p class="text-xs font-medium text-orange-500 mt-2">คณะอาจารย์</p>
                </div>
            </div>

            <!-- Recent Activities Box -->
            <div
                class="bg-surface rounded-2xl md:rounded-3xl shadow-card border border-border p-6 md:p-8 relative z-10 overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-48 h-48 bg-blue-50/30 rounded-full blur-3xl -mr-24 -mt-24 pointer-events-none"
                    aria-hidden="true">
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 md:mb-8">
                    <h2 class="text-lg md:text-xl font-bold text-text flex items-center gap-3">
                        ลงทะเบียนล่าสุด
                        <span
                            class="px-2.5 py-1 bg-primary/10 text-primary text-[10px] font-semibold rounded-lg">รายการใหม่</span>
                    </h2>
                    <a href="{{ route('students.index') }}"
                        class="text-primary font-semibold text-xs hover:text-primary-dark transition-colors duration-200 cursor-pointer">ดูนักเรียนทั้งหมด</a>
                </div>

                <div class="overflow-x-auto -mx-6 md:mx-0 px-6 md:px-0">
                    <table class="w-full text-left min-w-[600px] md:min-w-full">
                        <thead>
                            <tr class="text-xs font-semibold text-text-muted border-b border-border">
                                <th class="pb-4 pl-4">ข้อมูลนักเรียน</th>
                                <th class="pb-4">รหัสประจำตัว</th>
                                <th class="pb-4">รุ่น / สังกัด</th>
                                <th class="pb-4">วันที่บันทึก</th>
                                <th class="pb-4 text-right pr-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/50">
                            @forelse($recentStudents as $student)
                                <tr class="group/row hover:bg-surface-hover transition-colors duration-200">
                                    <td class="py-4 md:py-5 pl-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-surface-hover rounded-xl flex items-center justify-center text-text-muted group-hover/row:bg-primary group-hover/row:text-white transition-all duration-300 overflow-hidden shrink-0">
                                                @if($student->photo_path)
                                                    <img src="{{ asset('storage/' . $student->photo_path) }}"
                                                        class="w-full h-full object-cover"
                                                        alt="{{ $student->first_name_th }}">
                                                @else
                                                    <span
                                                        class="font-bold text-sm">{{ mb_substr($student->first_name_th, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-sm font-semibold text-text truncate">
                                                    {{ $student->title_th }}{{ $student->first_name_th }}
                                                    {{ $student->last_name_th }}</div>
                                                <div class="text-xs font-medium text-text-muted capitalize truncate">
                                                    {{ $student->first_name_en }} {{ $student->last_name_en }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 md:py-5">
                                        <span
                                            class="px-2.5 py-1 bg-surface-hover rounded-lg text-xs font-semibold text-text-secondary group-hover/row:bg-white transition-colors duration-200">{{ $student->student_id }}</span>
                                    </td>
                                    <td class="py-4 md:py-5">
                                        <div class="text-sm font-medium text-text-secondary">รุ่น
                                            {{ $student->batch }}</div>
                                        <div class="text-xs font-medium text-text-muted truncate">
                                            {{ $student->course->course_name_th ?? 'ภาคปกติ' }}</div>
                                    </td>
                                    <td class="py-4 md:py-5">
                                        <div class="text-sm font-medium text-text-secondary">
                                            {{ $student->created_at ? $student->created_at->format('d/m/Y') : '-' }}</div>
                                        <div
                                            class="text-xs font-medium text-text-muted opacity-0 group-hover/row:opacity-100 transition-opacity duration-200">
                                            เวลา {{ $student->created_at ? $student->created_at->format('H:i') : '' }} น.
                                        </div>
                                    </td>
                                    <td class="py-4 md:py-5 text-right pr-4">
                                        <a href="{{ route('students.index', ['search' => $student->student_id]) }}"
                                            class="inline-flex py-2 px-3 bg-surface border border-border rounded-lg text-xs font-semibold text-text-muted hover:text-primary hover:border-primary/50 hover:shadow-sm transition-all duration-200 active:scale-95 cursor-pointer">
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
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-14 h-14 bg-surface-hover rounded-full flex items-center justify-center">
                                                <svg class="w-7 h-7 text-text-disabled" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-text-muted font-medium text-sm">
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
</x-layouts.app>
</div>