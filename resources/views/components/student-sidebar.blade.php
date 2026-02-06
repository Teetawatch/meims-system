<aside x-data="{ open: false }"
    class="fixed top-0 left-0 z-40 w-72 h-screen transition-transform -translate-x-full lg:translate-x-0 bg-white border-r border-slate-100 flex flex-col shadow-sm">
    <!-- Profile Section -->
    <div class="p-8 pb-6 text-center border-b border-slate-50">
        <div class="relative inline-block mx-auto mb-4 group">
            <div
                class="w-24 h-24 rounded-3xl overflow-hidden ring-4 ring-blue-50 group-hover:ring-blue-100 transition-all shadow-xl">
                @if(auth('student')->user()->photo_path)
                    <img src="{{ asset('storage/' . auth('student')->user()->photo_path) }}" alt="Profile"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-blue-600 flex items-center justify-center text-white text-3xl font-black">
                        {{ mb_substr(auth('student')->user()->first_name_th, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-green-500 border-4 border-white rounded-full"></div>
        </div>
        <h3 class="font-bold text-slate-800 text-lg line-clamp-1">{{ auth('student')->user()->first_name_th }}
            {{ auth('student')->user()->last_name_th }}
        </h3>
        <p class="text-blue-600 text-xs font-bold mt-1 bg-blue-50 px-3 py-1 rounded-full inline-block">
            {{ auth('student')->user()->student_id }}
        </p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
        <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">เมนูหลัก</p>

        <x-student-sidebar-item icon="dashboard" label="Dashboard" route="student.dashboard" active="student.dashboard"
            color="blue" />
        <x-student-sidebar-item icon="profile" label="ข้อมูลส่วนตัว" route="student.profile" active="student.profile"
            color="indigo" />
        <x-student-sidebar-item icon="calendar" label="ตารางเรียน" route="student.timetable" active="student.timetable"
            color="pink" />
        <x-student-sidebar-item icon="grades" label="ผลการเรียน" route="student.grades" active="student.grades"
            color="emerald" />
        <x-student-sidebar-item icon="conduct" label="คะแนนความประพฤติ" route="student.conduct" active="student.conduct"
            color="orange" />
        <x-student-sidebar-item icon="survey" label="แบบสอบถาม" route="student.surveys" active="student.surveys"
            color="amber" />
        <x-student-sidebar-item icon="document" label="ดาวน์โหลดเอกสาร" route="student.documents"
            active="student.documents" color="purple" />
        <x-student-sidebar-item icon="grades" label="ระบบประเมิน" route="student.evaluation" active="student.evaluation"
            color="rose" />

        <div class="pt-6 mt-6 border-t border-slate-50">
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">ความปลอดภัย</p>
            <x-student-sidebar-item icon="lock" label="เปลี่ยนรหัสผ่าน" route="student.change-password"
                active="student.change-password" color="slate" />

            <button onclick="confirmLogout()"
                class="w-full flex items-center px-4 py-3 rounded-xl transition-all text-red-500 hover:bg-red-50 mt-2 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                <span>ออกจากระบบ</span>
            </button>
        </div>
    </nav>
</aside>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'ต้องการออกจากระบบ?',
            text: "คุณจะถูกนำกลับเข้าสู่หน้าเข้าสู่ระบบ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'ยืนยันออกจากระบบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('student.logout') }}";
            }
        })
    }
</script>