<x-layouts.app>
<div x-data="{ sidebarOpen: false }" @open-sidebar.window="sidebarOpen = true"
    class="flex min-h-screen bg-[#F8FAFC] font-['Outfit','Anuphan',sans-serif] text-slate-800 relative overflow-hidden">
    
    <!-- Premium Aurora Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] right-[-5%] w-[700px] h-[700px] bg-gradient-to-br from-blue-400/20 to-indigo-500/15 rounded-full blur-[120px] animate-blob mix-blend-multiply"></div>
        <div class="absolute top-[30%] left-[-10%] w-[600px] h-[600px] bg-gradient-to-tr from-purple-400/20 to-pink-400/15 rounded-full blur-[120px] animate-blob animation-delay-2000 mix-blend-multiply"></div>
        <div class="absolute bottom-[-10%] right-[10%] w-[800px] h-[800px] bg-gradient-to-bl from-cyan-400/20 to-blue-500/15 rounded-full blur-[140px] animate-blob animation-delay-4000 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-white/40 backdrop-blur-[1px]"></div>
    </div>

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity.duration.300ms @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="w-72 shrink-0 bg-white/80 backdrop-blur-2xl border-r border-white/60 shadow-[4px_0_24px_-12px_rgba(0,0,0,0.1)] flex flex-col fixed inset-y-0 left-0 z-50 transition-transform duration-500 ease-out">
        <x-sidebar />
    </aside>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-72 flex flex-col min-h-screen relative z-10 transition-all duration-300">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-30 bg-white/60 backdrop-blur-xl border-b border-white/40 shadow-sm supports-[backdrop-filter]:bg-white/40 px-6 lg:px-10 py-5 flex items-center justify-between transition-all">
            <div class="flex items-center gap-5">
                <button @click="sidebarOpen = true"
                    class="lg:hidden p-3 bg-white/90 hover:bg-white text-slate-600 rounded-2xl shadow-sm border border-slate-200/50 hover:shadow-md transition-all active:scale-95 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <div>
                    <h2 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-slate-800 to-slate-600 tracking-tight">จัดการการลงทะเบียน</h2>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <p class="text-[10px] font-bold text-slate-400">ศูนย์ควบคุมการลงทะเบียน</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-4 px-5 py-2.5 bg-white/90 border border-white rounded-[1.25rem] shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] backdrop-blur-md">
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-bold text-slate-400 leading-none mb-1">สถานะระบบ</span>
                        <span class="text-xs font-black {{ $registrationEnabled ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $registrationEnabled ? 'เปิดอยู่' : 'ปิดอยู่' }}
                        </span>
                    </div>
                    <div class="relative flex h-3 w-3">
                        <span class="{{ $registrationEnabled ? 'bg-emerald-400' : 'bg-rose-400' }} animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 {{ $registrationEnabled ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-6 lg:p-10 space-y-10">
            
            @if(session('message'))
            <div class="p-5 bg-emerald-50/80 backdrop-blur-xl border border-emerald-100 text-emerald-700 rounded-[1.5rem] flex items-center justify-between shadow-sm animate-fade-in-up">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-black text-sm">ทำรายการสำเร็จ</p>
                        <p class="text-xs font-bold opacity-80">{{ session('message') }}</p>
                    </div>
                </div>
                <button @click="$el.parentElement.remove()" class="p-2 hover:bg-emerald-100 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @endif

            <!-- Control Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <div class="lg:col-span-4">
                    <div class="bg-white/80 backdrop-blur-2xl rounded-[2.5rem] p-10 border border-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] sticky top-32 overflow-hidden group">
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-slate-50 rounded-full blur-3xl group-hover:bg-blue-50/50 transition-colors duration-1000"></div>
                        
                        <div class="relative z-10">
                            <div class="mb-10 text-center">
                                <div class="w-20 h-20 bg-slate-900 text-white rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-slate-900/30 group-hover:rotate-12 transition-transform duration-500">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m11-3V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7m4 2a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900 mb-2">ควบคุมสถานะ</h3>
                                <p class="text-sm text-slate-500 font-bold leading-relaxed px-4">จัดการการเข้าถึงหน้าลงทะเบียนของนักเรียนได้อย่างรวดเร็ว</p>
                            </div>

                            <form action="{{ route('admin.registration.toggle') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="enabled" value="{{ $registrationEnabled ? '0' : '1' }}">
                                
                                <button type="submit" 
                                    class="w-full relative group/btn overflow-hidden rounded-[1.5rem] p-1 transition-all duration-500 hover:scale-[1.02] active:scale-95 shadow-lg {{ $registrationEnabled ? 'shadow-rose-500/20' : 'shadow-indigo-500/20' }}">
                                    <div class="absolute inset-0 transition-all duration-500 group-hover/btn:scale-110 {{ $registrationEnabled ? 'bg-gradient-to-r from-rose-500 via-red-600 to-rose-700' : 'bg-gradient-to-r from-indigo-600 via-blue-600 to-indigo-700' }}"></div>
                                    <div class="relative bg-white group-hover/btn:bg-transparent transition-colors duration-500 rounded-[1.25rem] py-5 px-6 flex items-center justify-center gap-3">
                                        <span class="font-black text-sm {{ $registrationEnabled ? 'text-rose-600 group-hover/btn:text-white' : 'text-indigo-600 group-hover/btn:text-white' }} transition-colors">
                                            {{ $registrationEnabled ? 'กดเพื่อปิดการลงทะเบียน' : 'กดเพื่อเปิดการลงทะเบียน' }}
                                        </span>
                                        <svg class="w-5 h-5 {{ $registrationEnabled ? 'text-rose-500 group-hover/btn:text-white' : 'text-indigo-500 group-hover/btn:text-white' }} transition-all duration-500 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </div>
                                </button>
                            </form>

                            <div class="mt-10 pt-10 border-t border-slate-100/80">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-slate-400">ลิงก์ลงทะเบียนปกติ</span>
                                        <a href="{{ route('student.register') }}" target="_blank" class="text-[10px] font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors group/link">
                                            เข้าชมหน้าเว็บ
                                            <svg class="w-3 h-3 group-hover/link:translate-x-0.5 group-hover/link:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                                        <span class="text-[10px] font-bold text-slate-400">ลิงก์ลงทะเบียนหลักสูตรพิเศษ</span>
                                        <a href="{{ route('student.course-register') }}" target="_blank" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors group/link">
                                            เข้าชมหน้าเว็บ
                                            <svg class="w-3 h-3 group-hover/link:translate-x-0.5 group-hover/link:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="p-4 bg-slate-50/80 rounded-2xl flex items-center justify-between border border-slate-200/50 group/copy hover:bg-white hover:border-blue-200 transition-all mt-4">
                                    <code class="text-[11px] text-slate-500 font-mono truncate mr-4">{{ str_replace(['http://', 'https://'], '', route('student.register')) }}</code>
                                    <button onclick="copyRegistrationLink(this)" data-url="{{ route('student.register') }}"
                                        class="p-2.5 bg-white text-slate-400 hover:text-blue-600 rounded-xl transition-all border border-slate-200 group-hover/copy:border-blue-100 shadow-sm active:scale-90 text-[9px] font-black">
                                        <div id="copy-icon">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-10">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="bg-white/80 backdrop-blur-2xl rounded-[2.5rem] p-10 border border-white shadow-[0_20px_50px_rgba(0,0,0,0.035)] relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                            <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-blue-50/50 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10 flex flex-col h-full justify-between">
                                <div class="w-16 h-16 rounded-[1.5rem] bg-slate-900 text-white flex items-center justify-center mb-8 shadow-xl shadow-slate-900/20 group-hover:rotate-6 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 mb-2">จำนวนผู้ลงทะเบียนทั้งหมด</p>
                                    <h3 class="text-5xl font-black text-slate-900 tracking-tight">{{ number_format($totalRegistered) }}<span class="text-xl font-bold text-slate-400 ml-2">คน</span></h3>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/80 backdrop-blur-2xl rounded-[2.5rem] p-10 border border-white shadow-[0_20px_50px_rgba(0,0,0,0.035)] relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                            <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-indigo-50/50 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10 flex flex-col h-full justify-between">
                                <div class="w-16 h-16 rounded-[1.5rem] bg-indigo-600 text-white flex items-center justify-center mb-8 shadow-xl shadow-indigo-600/20 group-hover:rotate-6 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 mb-2">เวลาอัปเดตล่าสุด</p>
                                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $recentStudents->first()?->created_at?->diffForHumans() ?? 'ไม่มีข้อมูล' }}</h3>
                                    <p class="text-[10px] text-indigo-500 mt-2 font-black">อัปเดตข้อมูลอัตโนมัติ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent List -->
                    <div class="bg-white/80 backdrop-blur-2xl rounded-[3rem] border border-white shadow-[0_20px_50px_rgba(0,0,0,0.035)] overflow-hidden">
                        <div class="p-10 border-b border-slate-100/60 flex justify-between items-center">
                            <div>
                                <h2 class="text-2xl font-black text-slate-900 tracking-tight">ผู้ลงทะเบียนล่าสุด</h2>
                                <p class="text-xs text-slate-400 font-bold mt-1">รายการการลงทะเบียน 10 อันดับล่าสุดในระบบ</p>
                            </div>
                            <a href="{{ route('students.index') }}" class="inline-flex items-center gap-2 py-3 px-6 bg-slate-50 hover:bg-slate-900 text-slate-600 hover:text-white rounded-2xl text-xs font-black transition-all group/all active:scale-95 shadow-sm border border-slate-200/50">
                                ดูรายชื่อทั้งหมด
                                <svg class="w-4 h-4 group-hover/all:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-slate-100/40">
                                    @forelse($recentStudents as $student)
                                    <tr class="group hover:bg-slate-50/60 transition-all duration-300">
                                        <td class="py-6 px-10">
                                            <div class="flex items-center gap-6">
                                                <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-slate-400 font-black shadow-[0_4px_15px_-3px_rgba(0,0,0,0.08)] border border-slate-100 overflow-hidden group-hover:scale-110 transition-transform duration-500">
                                                    @if($student->photo_path)
                                                        <img src="{{ asset('storage/' . $student->photo_path) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="text-lg">{{ mb_substr($student->first_name_th, 0, 1) }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-base font-black text-slate-900 leading-tight">{{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</p>
                                                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.1em] mt-1">{{ $student->student_id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 px-10">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-slate-700">{{ $student->course_name }}</span>
                                                <span class="text-[10px] font-bold text-slate-400 mt-0.5">หลักสูตรที่เลือก</span>
                                            </div>
                                        </td>
                                        <td class="py-6 px-10 text-right">
                                            @if($student->created_at)
                                                <p class="text-xs font-black text-slate-900 leading-none mb-1">{{ $student->created_at->format('d/m/Y') }}</p>
                                                <p class="text-[10px] font-bold text-slate-400 leading-none">{{ $student->created_at->format('H:i') }} น.</p>
                                            @else
                                                <p class="text-xs font-black text-slate-400 leading-none">-</p>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="py-32 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center border-2 border-dashed border-slate-200">
                                                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                    </svg>
                                                </div>
                                                <p class="font-bold text-slate-300 text-xs text-center">ไม่มีข้อมูลการลงทะเบียนในขณะนี้</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fade-in-up 0.5s ease-out forwards;
}
</style>

<script>
function copyRegistrationLink(btn) {
    const url = btn.getAttribute('data-url');
    navigator.clipboard.writeText(url);
    
    const originalContent = btn.innerHTML;
    btn.innerHTML = 'คัดลอกแล้ว';
    btn.classList.add('text-blue-600', 'border-blue-200');
    
    setTimeout(() => {
        btn.innerHTML = originalContent;
        btn.classList.remove('text-blue-600', 'border-blue-200');
    }, 2000);
}
</script>
</x-layouts.app>
