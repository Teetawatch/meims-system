<div class="w-full h-full flex flex-col">
    <!-- Logo -->
    <div class="h-20 flex items-center px-8 border-b border-slate-100 justify-between shrink-0">
        <div class="flex items-center">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30 mr-3">
                M</div>
            <span class="text-xl font-bold text-slate-800 tracking-tight">MEIMS</span>
        </div>
        <!-- Close Button for Mobile -->
        <button @click="sidebarOpen = false" class="lg:hidden p-2 text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto custom-scrollbar">

        <!-- Group: ภาพรวมระบบ -->
        <div>
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">ภาพรวมระบบ</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? '' : 'group-hover:text-blue-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">แดชบอร์ดสรุปผล</span>
                </a>
            </div>
        </div>

        <!-- Group: การจัดการข้อมูลพื้นฐาน -->
        <div>
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">จัดการข้อมูลสารสนเทศ
            </p>
            <div class="space-y-1">
                <a href="{{ route('students.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('students.index') || request()->routeIs('students.show') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('students.index') || request()->routeIs('students.show') ? '' : 'group-hover:text-blue-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">ทะเบียนรายชื่อนักเรียน</span>
                </a>

                <a href="{{ route('teachers.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('teachers.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('teachers.index') ? '' : 'group-hover:text-blue-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-bold text-sm">ข้อมูลครู</span>
                </a>

                <a href="{{ route('guardians.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('guardians.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('guardians.index') ? '' : 'group-hover:text-teal-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="font-bold text-sm">ทะเบียนผู้ปกครอง</span>
                </a>

                <a href="{{ route('announcements.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('announcements.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('announcements.index') ? '' : 'group-hover:text-orange-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span class="font-bold text-sm">ประกาศข่าวสาร</span>
                </a>

                <a href="{{ route('banners.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('banners.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('banners.index') ? '' : 'group-hover:text-blue-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-bold text-sm">จัดการ Hero Banner</span>
                </a>


                <a href="{{ route('courses.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('courses.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('courses.index') ? '' : 'group-hover:text-pink-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">หลักสูตรการศึกษา</span>
                </a>

                <a href="{{ route('subjects.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('subjects.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('subjects.index') ? '' : 'group-hover:text-indigo-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.247 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">รายวิชาเรียน</span>
                </a>
            </div>
        </div>

        <!-- Group: งานวิชาการและผลการเรียน -->
        <div>
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">งานวิชาการและประเมินผล
            </p>
            <div class="space-y-1">
                <a href="{{ route('grades.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('grades.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('grades.index') ? '' : 'group-hover:text-emerald-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <span class="font-bold text-sm">บันทึกผลการเรียน</span>
                </a>

                <a href="{{ route('transcripts.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('transcripts.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('transcripts.index') ? '' : 'group-hover:text-indigo-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">ออกใบระเบียบผลเรียน</span>
                </a>

                <a href="{{ route('students.conduct') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('students.conduct') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('students.conduct') ? '' : 'group-hover:text-red-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold text-sm">วินัยความประพฤติ</span>
                </a>
            </div>
        </div>

        <!-- Group: บริการและสื่อการสอน -->
        <div>
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">บริการและสื่อการสอน</p>
            <div class="space-y-1">
                <a href="{{ route('timetables.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('timetables.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('timetables.index') ? '' : 'group-hover:text-pink-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">ตารางเรียนรายวัน</span>
                </a>

                <a href="{{ route('documents.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('documents.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('documents.index') ? '' : 'group-hover:text-amber-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">คลังสื่อและเอกสาร</span>
                </a>

                <a href="{{ route('surveys.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('surveys.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('surveys.index') ? '' : 'group-hover:text-amber-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">ระบบแบบประเมิน</span>
                </a>
            </div>
        </div>

        <!-- Group: รายงานและสรุปผล -->
        <div>
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">รายงานและหน่วยประมวลผล
            </p>
            <div class="space-y-1">
                <a href="{{ route('reports.students') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('reports.students') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.students') ? '' : 'group-hover:text-orange-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">สรุปสถิตินักเรียน</span>
                </a>

                <a href="{{ route('reports.evaluations') }}"
                    class="flex items-center px-4 py-3 rounded-xl group transition-all {{ request()->routeIs('reports.evaluations') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.evaluations') ? '' : 'group-hover:text-rose-500 transition-colors' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                        </path>
                    </svg>
                    <span class="font-bold text-sm">สรุปผลการประเมิน</span>
                </a>
            </div>
        </div>

    </nav>

    <!-- Profile -->
    <div class="p-4 border-t border-slate-100 shrink-0">
        <div class="bg-gradient-to-r from-slate-100 to-slate-50 p-4 rounded-2xl flex items-center space-x-3">
            <div
                class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 overflow-hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-900 truncate">ผู้บริหารระบบ</p>
                <p class="text-[10px] text-slate-500 truncate font-medium uppercase tracking-widest text-[8px]">
                    Administrator</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                @csrf
                <button type="submit"
                    class="text-slate-400 hover:text-red-500 transition-colors bg-white p-2 rounded-lg hover:bg-red-50"
                    title="ออกจากระบบ">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>