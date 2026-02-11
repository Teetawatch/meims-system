<div class="p-8 md:p-12">

        <header class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">ความปลอดภัย</h1>
            <p class="text-slate-500 font-medium mt-1">จัดการรหัสผ่านและบัญชีผู้ใช้ของคุณ</p>
        </header>

        <div class="max-w-4xl mx-auto md:mx-0 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Form -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-100 relative overflow-hidden">
                    <form wire:submit="updatePassword" class="space-y-8 relative z-10">
                        <div>
                            <label class="block text-sm font-black text-slate-700 mb-2 ml-1">รหัสผ่านปัจจุบัน <span
                                    class="text-red-500">*</span></label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </span>
                                <input type="password" wire:model="current_password"
                                    class="w-full pl-12 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white focus:ring-0 outline-none transition-all placeholder:text-slate-300 font-medium"
                                    placeholder="ระบุรหัสผ่านเดิมของคุณ">
                            </div>
                            @error('current_password') <span
                                class="text-red-500 text-xs mt-2 block font-bold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </span> @enderror
                        </div>

                        <div class="pt-8 border-t border-slate-50 space-y-6">
                            <div>
                                <label class="block text-sm font-black text-slate-700 mb-2 ml-1">รหัสผ่านใหม่ <span
                                        class="text-red-500">*</span></label>
                                <div class="relative group">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 17 6 22.464V20H4v-2.464L10.536 13.536a6 6 0 1110.464 0z">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="password" wire:model="new_password" placeholder="อย่างน้อย 8 ตัวอักษร"
                                        class="w-full pl-12 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white focus:ring-0 outline-none transition-all placeholder:text-slate-300 font-medium">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-black text-slate-700 mb-2 ml-1">ยืนยันรหัสผ่านใหม่
                                    <span class="text-red-500">*</span></label>
                                <div class="relative group">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="password" wire:model="new_password_confirmation"
                                        placeholder="กรอกรหัสผ่านใหม่อีกครั้ง"
                                        class="w-full pl-12 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white focus:ring-0 outline-none transition-all placeholder:text-slate-300 font-medium">
                                </div>
                            </div>

                            @error('new_password') <span
                                class="text-red-500 text-xs mt-2 block font-bold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </span> @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl shadow-slate-900/10 hover:bg-blue-600 hover:shadow-blue-600/20 transform hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                    </path>
                                </svg>
                                บันทึกการเปลี่ยนแปลง
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Instructions -->
            <div class="lg:col-span-1 space-y-6">
                <div
                    class="bg-blue-500 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-black mb-2">คำแนะนำ</h3>
                        <p class="text-blue-100 text-sm leading-relaxed mb-6">เพื่อความปลอดภัยสูงสุดของข้อมูลส่วนตัว
                            กรุณาตั้งรหัสผ่านที่คาดเดายาก</p>

                        <ul class="space-y-3 text-sm text-blue-50 font-medium">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                ความยาวอย่างน้อย 8 ตัวอักษร
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                มีตัวอักษรพิมพ์ใหญ่และเล็ก
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                มีตัวเลขผสมอยู่ด้วย
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-2">ลืมรหัสผ่าน?</h3>
                    <p class="text-slate-400 text-sm mb-4">หากคุณจำรหัสผ่านเดิมไม่ได้ กรุณาติดต่อเจ้าหน้าที่ฝ่ายทะเบียน
                    </p>
                    <button type="button"
                        class="w-full py-3 bg-slate-50 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-100 transition-colors">
                        ติดต่อเจ้าหน้าที่
                    </button>
                </div>
            </div>
        </div>
</div>