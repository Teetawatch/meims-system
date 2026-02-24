<div
    class="relative min-h-screen flex items-center justify-center overflow-hidden bg-slate-50 font-['Outfit','Anuphan']">

    <!-- Premium Animated Background -->
    <div class="absolute inset-0 w-full h-full overflow-hidden">
        <div
            class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-blue-100/50 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse">
        </div>
        <div
            class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-indigo-100/50 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-[10%] left-[20%] w-[40%] h-[40%] bg-purple-100/50 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse animation-delay-4000">
        </div>

        <!-- Subtle Grid Pattern -->
        <div
            class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100">
        </div>
    </div>

    <!-- Login Card Container -->
    <div class="relative w-full max-w-lg p-4 sm:p-8 mx-4 z-10">
        <div
            class="bg-white/70 backdrop-blur-3xl rounded-[3rem] border border-white shadow-[0_32px_64px_-16px_rgba(0,0,0,0.08)] overflow-hidden">

            <div class="p-8 sm:p-12">
                <!-- Header -->
                <div class="text-center mb-12">
                    <div class="inline-flex relative mb-8">
                        <div class="absolute inset-0 bg-blue-500 blur-2xl opacity-20 animate-pulse"></div>
                        <div
                            class="relative inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-tr from-blue-600 to-indigo-700 shadow-2xl shadow-blue-500/40 transform -rotate-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight mb-3">เข้าสู่ระบบ</h2>
                    <div class="flex items-center justify-center gap-2">
                        <span class="h-px w-8 bg-slate-200"></span>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">MEIMS Management System
                        </p>
                        <span class="h-px w-8 bg-slate-200"></span>
                    </div>
                </div>

                <form wire:submit.prevent="login" class="space-y-8">
                    @if (session()->has('error'))
                        <div
                            class="p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3 text-red-600 text-sm font-bold animate-shake">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Input Group -->
                    <div class="space-y-5">
                        <!-- Email -->
                        <div class="relative group">
                            <label
                                class="absolute -top-2.5 left-5 px-2 bg-white text-[10px] font-black text-slate-400 uppercase tracking-widest z-20 group-focus-within:text-blue-600 transition-colors">อีเมลผู้ใช้งาน</label>
                            <input type="email" wire:model="email"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-slate-900 placeholder-slate-300 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold"
                                placeholder="example@email.com">
                            <div
                                class="absolute left-0 top-0 h-full w-14 flex items-center justify-center text-slate-400 transition-colors group-focus-within:text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            @error('email') <span
                                class="text-red-500 text-[10px] font-bold mt-1.5 block pl-4 uppercase tracking-wide italic">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="relative group">
                            <label
                                class="absolute -top-2.5 left-5 px-2 bg-white text-[10px] font-black text-slate-400 uppercase tracking-widest z-20 group-focus-within:text-blue-600 transition-colors">รหัสผ่าน</label>
                            <input type="password" wire:model="password"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-slate-900 placeholder-slate-300 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold"
                                placeholder="••••••••••••">
                            <div
                                class="absolute left-0 top-0 h-full w-14 flex items-center justify-center text-slate-400 transition-colors group-focus-within:text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            @error('password') <span
                                class="text-red-500 text-[10px] font-bold mt-1.5 block pl-4 uppercase tracking-wide italic">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" wire:model="remember"
                                    class="peer appearance-none w-6 h-6 rounded-lg border-2 border-slate-100 bg-slate-50 checked:bg-blue-600 checked:border-blue-600 transition-all cursor-pointer">
                                <svg class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span
                                class="text-sm font-bold text-slate-500 group-hover:text-slate-700 transition-colors">จดจำฉันไว้ในระบบ</span>
                        </label>
                        <a href="#"
                            class="text-xs font-black text-blue-600 hover:text-indigo-700 uppercase tracking-widest transition-colors">ลืมรหัสผ่าน?</a>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="relative w-full overflow-hidden py-5 px-6 bg-slate-900 text-white font-black rounded-[2rem] shadow-2xl shadow-slate-900/20 transform active:scale-[0.98] transition-all hover:bg-black group">
                            <div class="relative z-10 flex items-center justify-center gap-3">
                                <span class="text-lg">เข้าสู่ระบบ</span>
                                <svg class="w-6 h-6 group-hover:translate-x-1.5 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-12 text-center">
                    <p class="text-slate-400 text-sm font-bold">
                        ยังไม่มีบัญชีผู้ใช้?
                        <a href="{{ route('student.register') }}"
                            class="inline-flex items-center text-blue-600 hover:text-indigo-700 font-black ml-1 group">
                            สมัครสมาชิกนักเรียน
                            <span
                                class="block w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom Branding -->
        <p class="mt-12 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">MEIMS &copy;
            {{ date('Y') }} • Logistics School Management System</p>
    </div>

    <style>
        @keyframes blob {
            0% {
                transform: scale(1);
            }

            33% {
                transform: scale(1.1) translate(30px, -50px);
            }

            66% {
                transform: scale(0.9) translate(-20px, 20px);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite alternate ease-in-out;
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
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>
</div>