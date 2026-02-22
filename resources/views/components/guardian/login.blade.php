<div class="min-h-screen flex items-center justify-center p-6 bg-slate-50 relative overflow-hidden font-sans">
    <!-- Background -->
    <div class="absolute inset-0 w-full h-full overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-teal-100/40 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-emerald-100/40 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[40%] h-[40%] bg-cyan-100/40 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="max-w-2xl w-full relative z-10">
        <!-- Header -->
        <div class="flex flex-col items-center text-center mb-12">
            <div class="inline-flex relative mb-8">
                <div class="absolute inset-0 bg-teal-500 blur-2xl opacity-20 animate-pulse"></div>
                <div class="relative inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-teal-600 to-emerald-700 rounded-[2.5rem] shadow-2xl shadow-teal-500/40 mb-2 transition-all hover:scale-105 active:scale-95 duration-500">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-900 whitespace-nowrap">
                ระบบผู้ปกครอง : MEIMS Parent Portal</h1>
            <div class="flex items-center justify-center gap-3 mt-3">
                <span class="h-px w-6 bg-slate-200"></span>
                <p class="text-slate-500 font-bold uppercase tracking-[0.2em] text-[10px]">โรงเรียนพลาธิการ
                    กรมพลาธิการทหารเรือ</p>
                <span class="h-px w-6 bg-slate-200"></span>
            </div>
        </div>

        <!-- Login Card -->
        <div class="bg-white/70 backdrop-blur-3xl rounded-[3.5rem] p-10 sm:p-14 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.06)] border border-white relative overflow-hidden">

            <form wire:submit="login" class="space-y-10 relative z-10">
                <div class="space-y-6">
                    <!-- Username -->
                    <div class="relative group/input">
                        <label class="absolute -top-3 left-6 px-2 bg-white/50 backdrop-blur-sm text-[10px] font-black text-slate-400 uppercase tracking-widest z-20 group-focus-within/input:text-teal-600 transition-colors">ชื่อผู้ใช้งาน</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-teal-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model="username"
                                class="w-full pl-16 pr-6 py-5 bg-slate-50/50 border border-slate-100 rounded-3xl text-slate-900 placeholder-slate-300 focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all outline-none font-bold"
                                placeholder="ชื่อผู้ใช้งานของคุณ">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="relative group/input">
                        <label class="absolute -top-3 left-6 px-2 bg-white/50 backdrop-blur-sm text-[10px] font-black text-slate-400 uppercase tracking-widest z-20 group-focus-within/input:text-teal-600 transition-colors">รหัสผ่าน</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-teal-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input type="password" wire:model="password"
                                class="w-full pl-16 pr-6 py-5 bg-slate-50/50 border border-slate-100 rounded-3xl text-slate-900 placeholder-slate-300 focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all outline-none font-bold"
                                placeholder="••••••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between px-2">
                    <label class="flex items-center cursor-pointer">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" wire:model="remember"
                                class="peer appearance-none w-6 h-6 rounded-lg border-2 border-slate-100 bg-slate-50 checked:bg-teal-500 checked:border-teal-500 transition-all">
                            <svg class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm text-slate-500 font-bold">จำฉันไว้ในระบบ</span>
                    </label>
                </div>

                @if($errors->any())
                    <div class="p-5 bg-red-50 text-red-600 text-sm font-bold rounded-3xl border border-red-100 flex items-center gap-3">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit"
                    class="relative w-full overflow-hidden py-5 bg-gradient-to-r from-teal-600 to-emerald-700 text-white font-black rounded-3xl shadow-[0_20px_40px_-12px_rgba(13,148,136,0.35)] hover:shadow-[0_30px_60px_-12px_rgba(13,148,136,0.45)] transform hover:-translate-y-1 active:scale-[0.98] transition-all duration-500 group/btn">
                    <span class="relative z-10 flex items-center justify-center gap-3 text-lg tracking-tight">
                        เข้าสู่ระบบผู้ปกครอง
                        <svg class="w-6 h-6 group-hover/btn:translate-x-2 transition-transform duration-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-700 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-700"></div>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center text-slate-400">
            <p class="text-[11px] font-black uppercase tracking-[0.2em] mb-4">
                MEIMS &copy; {{ date('Y') }} • Parent Portal
            </p>
            <p class="text-xs font-bold leading-relaxed opacity-60">
                หากพบปัญหาการเข้าใช้งาน กรุณาติดต่อกองทะเบียนและวัดผล<br>โรงเรียนพลาธิการ กรมพลาธิการทหารเรือ
            </p>
        </div>
    </div>
</div>
