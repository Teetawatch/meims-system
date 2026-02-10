<div class="w-full h-full flex flex-col bg-white">
    <!-- Profile Section -->
    <div class="p-8 pb-6 text-center border-b border-slate-50">
        <div class="relative inline-block mx-auto mb-4">
            <div class="w-20 h-20 rounded-2xl overflow-hidden ring-4 ring-teal-50 shadow-lg bg-teal-600 flex items-center justify-center text-white text-2xl font-bold">
                {{ mb_substr(auth('guardian')->user()->first_name_th, 0, 1) }}
            </div>
        </div>
        <h3 class="font-bold text-slate-800 text-lg line-clamp-1">{{ auth('guardian')->user()->first_name_th }}
            {{ auth('guardian')->user()->last_name_th }}
        </h3>
        <p class="text-teal-600 text-xs font-bold mt-1 bg-teal-50 px-3 py-1 rounded-full inline-block">
            {{ auth('guardian')->user()->relationship ?? 'ผู้ปกครอง' }}
        </p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
        <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">เมนูหลัก</p>

        <a href="{{ route('guardian.dashboard') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all font-medium {{ request()->routeIs('guardian.dashboard') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>หน้าหลัก</span>
        </a>

        <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 mt-6 pt-6 border-t border-slate-50">บุตรหลาน</p>

        @foreach(auth('guardian')->user()->students as $child)
            <a href="{{ route('guardian.student', $child->id) }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all font-medium {{ request()->is('guardian/student/' . $child->id) ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs mr-3 shrink-0">
                    {{ mb_substr($child->first_name_th, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <span class="block truncate text-sm">{{ $child->first_name_th }} {{ $child->last_name_th }}</span>
                    <span class="block text-xs text-slate-400">{{ $child->student_id }}</span>
                </div>
            </a>
        @endforeach

        <div class="pt-6 mt-6 border-t border-slate-50">
            <button onclick="confirmLogout()"
                class="w-full flex items-center px-4 py-3 rounded-xl transition-all text-red-500 hover:bg-red-50 mt-2 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>ออกจากระบบ</span>
            </button>
        </div>
    </nav>
</div>

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
                window.location.href = "{{ route('guardian.logout') }}";
            }
        })
    }
</script>
