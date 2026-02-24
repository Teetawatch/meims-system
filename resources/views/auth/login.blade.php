<x-layouts.app>
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-background font-body">

    <!-- Premium Animated Background (ui-ux-pro-max: transform-performance) -->
    <div class="absolute inset-0 w-full h-full overflow-hidden" aria-hidden="true">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-blue-100/40 rounded-full mix-blend-multiply filter blur-[100px] animate-blob">
        </div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-indigo-100/40 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-2000">
        </div>
        <div class="absolute -bottom-[10%] left-[20%] w-[40%] h-[40%] bg-purple-100/30 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-4000">
        </div>
    </div>

    <!-- Login Card Container -->
    <div class="relative w-full max-w-md p-4 sm:p-8 mx-4 z-10">
        <div class="bg-white/80 backdrop-blur-2xl rounded-3xl border border-white/90 shadow-elevated overflow-hidden">

            <div class="p-8 sm:p-10">
                <!-- Header -->
                <div class="text-center mb-10">
                    <div class="inline-flex relative mb-6">
                        <div class="absolute inset-0 bg-primary blur-2xl opacity-15 animate-pulse" aria-hidden="true"></div>
                        <div class="relative inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-primary-dark shadow-lg shadow-primary/30 transform -rotate-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-text tracking-tight mb-2">เข้าสู่ระบบ</h1>
                    <div class="flex items-center justify-center gap-2">
                        <span class="h-px w-8 bg-border" aria-hidden="true"></span>
                        <p class="text-text-muted font-medium text-xs tracking-wide">MEIMS Management System</p>
                        <span class="h-px w-8 bg-border" aria-hidden="true"></span>
                    </div>
                </div>

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf
                    
                    @if (session()->has('error'))
                        <div class="p-4 bg-error-light border border-red-200 rounded-xl flex items-center gap-3 text-error text-sm font-medium animate-shake"
                            role="alert">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Input Group -->
                    <div class="space-y-4">
                        <!-- Email -->
                        <div class="relative group">
                            <label for="login-email" class="absolute -top-2 left-4 px-2 bg-white text-[10px] font-semibold text-text-muted uppercase tracking-wider z-20 group-focus-within:text-primary transition-colors duration-200">อีเมลผู้ใช้งาน</label>
                            <input type="email" name="email" id="login-email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-12 pr-4 py-3.5 bg-surface border border-border rounded-xl text-text placeholder-text-disabled focus:outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all duration-200 font-medium"
                                placeholder="example@email.com">
                            <div class="absolute left-0 top-0 h-full w-12 flex items-center justify-center text-text-disabled transition-colors duration-200 group-focus-within:text-primary" aria-hidden="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            @error('email') 
                                <span class="text-error text-xs font-medium mt-1.5 block pl-4">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="relative group">
                            <label for="login-password" class="absolute -top-2 left-4 px-2 bg-white text-[10px] font-semibold text-text-muted uppercase tracking-wider z-20 group-focus-within:text-primary transition-colors duration-200">รหัสผ่าน</label>
                            <input type="password" name="password" id="login-password" required
                                class="w-full pl-12 pr-4 py-3.5 bg-surface border border-border rounded-xl text-text placeholder-text-disabled focus:outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all duration-200 font-medium"
                                placeholder="••••••••••••">
                            <div class="absolute left-0 top-0 h-full w-12 flex items-center justify-center text-text-disabled transition-colors duration-200 group-focus-within:text-primary" aria-hidden="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            @error('password') 
                                <span class="text-error text-xs font-medium mt-1.5 block pl-4">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" name="remember" class="peer appearance-none w-5 h-5 rounded-md border-2 border-border bg-surface checked:bg-primary checked:border-primary transition-all duration-200 cursor-pointer">
                                <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-text-secondary group-hover:text-text transition-colors duration-200">จดจำฉันไว้ในระบบ</span>
                        </label>
                        <a href="#" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors duration-200 cursor-pointer">ลืมรหัสผ่าน?</a>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="relative w-full overflow-hidden py-4 px-6 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/25 transform active:scale-[0.98] transition-all duration-200 hover:bg-primary-dark hover:shadow-xl hover:shadow-primary/30 cursor-pointer group">
                            <div class="relative z-10 flex items-center justify-center gap-2">
                                <span class="text-base">เข้าสู่ระบบ</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-text-muted text-sm font-medium">
                        ยังไม่มีบัญชีผู้ใช้?
                        <a href="{{ route('student.register') }}"
                            class="inline-flex items-center text-primary hover:text-primary-dark font-semibold ml-1 transition-colors duration-200 cursor-pointer">
                            สมัครสมาชิกนักเรียน
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom Branding -->
        <p class="mt-8 text-center text-[10px] font-medium text-text-disabled tracking-wide">MEIMS &copy;
            {{ date('Y') }} — ระบบบริหารจัดการข้อมูลสารสนเทศด้านการศึกษา</p>
    </div>
</div>
</x-layouts.app>
