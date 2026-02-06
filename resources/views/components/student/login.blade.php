<div
    class="min-h-screen flex items-center justify-center p-6 bg-slate-50 relative overflow-hidden font-['Outfit','Anuphan']">
    <!-- Premium Animated Background -->
    <div class="absolute inset-0 w-full h-full overflow-hidden">
        <div
            class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-blue-100/40 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse">
        </div>
        <div
            class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-indigo-100/40 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-[10%] left-[20%] w-[40%] h-[40%] bg-emerald-100/40 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse animation-delay-4000">
        </div>

        <!-- Subtle Pattern -->
        <div
            class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.15] brightness-100 italic">
        </div>
    </div>

    <div class="max-w-xl w-full relative z-10">
        <!-- Logo/Header -->
        <div class="text-center mb-12">
            <div class="inline-flex relative mb-8">
                <div class="absolute inset-0 bg-blue-500 blur-2xl opacity-20 animate-pulse"></div>
                <div
                    class="relative inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] shadow-2xl shadow-blue-500/40 mb-2 group transition-all hover:scale-105 active:scale-95 duration-500">
                    <svg class="w-12 h-12 text-white transform group-hover:rotate-12 transition-transform duration-500"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Student Portal</h1>
            <div class="flex items-center justify-center gap-3 mt-3">
                <span class="h-px w-6 bg-slate-200"></span>
                <p class="text-slate-500 font-bold uppercase tracking-[0.2em] text-[10px]">Logistics School Portal</p>
                <span class="h-px w-6 bg-slate-200"></span>
            </div>
        </div>

        <!-- Login Card -->
        <div
            class="bg-white/70 backdrop-blur-3xl rounded-[3.5rem] p-10 sm:p-14 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.06)] border border-white relative overflow-hidden group/card transition-all duration-500 hover:shadow-[0_48px_80px_-24px_rgba(0,0,0,0.08)]">

            <!-- Hidden Gradient Decoration -->
            <div
                class="absolute -top-24 -right-24 w-48 h-48 bg-gradient-to-br from-blue-500/10 to-transparent rounded-full blur-3xl group-hover/card:scale-150 transition-transform duration-1000">
            </div>

            <form wire:submit="login" class="space-y-10 relative z-10">
                <div class="space-y-6">
                    <!-- Username -->
                    <div class="relative group/input">
                        <label
                            class="absolute -top-3 left-6 px-2 bg-white/50 backdrop-blur-sm text-[10px] font-black text-slate-400 uppercase tracking-widest z-20 group-focus-within/input:text-blue-600 transition-colors">รหัสนักเรียน
                            / ชื่อผู้ใช้</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-blue-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model="username"
                                class="w-full pl-16 pr-6 py-5 bg-slate-50/50 border border-slate-100 rounded-3xl text-slate-900 placeholder-slate-300 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none font-bold"
                                placeholder="รหัสผู้ใช้งานของคุณ">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="relative group/input">
                        <label
                            class="absolute -top-3 left-6 px-2 bg-white/50 backdrop-blur-sm text-[10px] font-black text-slate-400 uppercase tracking-widest z-20 group-focus-within/input:text-blue-600 transition-colors">รหัสผ่านลับ</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-blue-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input type="password" wire:model="password"
                                class="w-full pl-16 pr-6 py-5 bg-slate-50/50 border border-slate-100 rounded-3xl text-slate-900 placeholder-slate-300 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none font-bold"
                                placeholder="••••••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between px-2">
                    <label class="flex items-center cursor-pointer group/check">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" wire:model="remember"
                                class="peer appearance-none w-6 h-6 rounded-lg border-2 border-slate-100 bg-slate-50 checked:bg-emerald-500 checked:border-emerald-500 transition-all">
                            <svg class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span
                            class="ml-3 text-sm text-slate-500 font-bold group-hover/check:text-slate-800 transition-colors">จำฉันไว้ในระบบ</span>
                    </label>
                    <a href="#"
                        class="text-xs font-black text-blue-600 hover:text-indigo-700 transition-colors uppercase tracking-widest">ลืมรหัสผ่าน?</a>
                </div>

                @if($errors->any())
                    <div
                        class="p-5 bg-red-50 text-red-600 text-sm font-bold rounded-3xl border border-red-100 flex items-center gap-3 animate-shake">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit"
                    class="relative w-full overflow-hidden py-5 bg-slate-900 text-white font-black rounded-3xl shadow-[0_20px_40px_-12px_rgba(15,23,42,0.3)] hover:shadow-[0_25px_50px_-12px_rgba(15,23,42,0.4)] transform hover:-translate-y-1 active:scale-[0.98] transition-all duration-500 group/btn">
                    <span class="relative z-10 flex items-center justify-center gap-3 text-lg tracking-tight">
                        เข้าสู่ระบบพอร์ทัล
                        <svg class="w-6 h-6 group-hover/btn:translate-x-2 transition-transform duration-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-700">
                    </div>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center text-slate-400">
            <p class="text-[11px] font-black uppercase tracking-[0.2em] mb-4">
                MEIMS &copy; {{ date('Y') }} • All Rights Reserved
            </p>
            <p class="text-xs font-bold leading-relaxed opacity-60">
                หากพบปัญหาการเข้าใช้งาน กรุณาติดต่อกองทะเบียนและวัดผล<br>โรงเรียนพลาธิการ กรมพลาธิการทหารเรือ
            </p>
        </div>
    </div>

    <style>
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.4;
            }

            50% {
                transform: scale(1.15);
                opacity: 0.6;
            }
        }

        .animate-pulse {
            animation: pulse 8s infinite ease-in-out;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-8px);
            }

            75% {
                transform: translateX(8px);
            }
        }

        .animate-shake {
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }
    </style>
</div>