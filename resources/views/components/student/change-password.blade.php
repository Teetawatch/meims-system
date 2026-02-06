<div class="min-h-screen flex bg-slate-50">
    <x-student-sidebar />
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">ความปลอดภัย</h1>
            <p class="text-slate-500 font-medium mt-1">เปลี่ยนรหัสผ่านเพื่อความปลอดภัยของข้อมูลส่วนตัว</p>
        </header>

        <div class="max-w-xl mx-auto md:mx-0">
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                <form wire:submit="updatePassword" class="space-y-8">
                    <div>
                        <label
                            class="block text-sm font-black text-slate-700 mb-2 uppercase tracking-widest text-[10px] ml-1">รหัสผ่านปัจจุบัน</label>
                        <div class="relative group">
                            <input type="password" wire:model="current_password"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-[1.5rem] focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder:text-slate-300">
                        </div>
                        @error('current_password') <span
                        class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <label
                            class="block text-sm font-black text-slate-700 mb-2 uppercase tracking-widest text-[10px] ml-1">รหัสผ่านใหม่</label>
                        <input type="password" wire:model="new_password"
                            placeholder="รหัสผ่านใหม่ (อย่างน้อย 8 ตัวอักษร)"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-[1.5rem] focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder:text-slate-300 mb-6">

                        <label
                            class="block text-sm font-black text-slate-700 mb-2 uppercase tracking-widest text-[10px] ml-1">ยืนยันรหัสผ่านใหม่</label>
                        <input type="password" wire:model="new_password_confirmation"
                            placeholder="กรอกรหัสผ่านใหม่อีกครั้ง"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-[1.5rem] focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder:text-slate-300">

                        @error('new_password') <span
                        class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-5 bg-slate-900 text-white font-black rounded-[1.5rem] shadow-xl hover:bg-black transform hover:-translate-y-1 transition-all active:scale-95">
                            บันทึกการเปลี่ยนรหัสผ่าน
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-8 p-6 bg-blue-50 rounded-[1.5rem] border border-blue-100 flex items-start gap-4">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h5 class="text-sm font-bold text-blue-800">คำแนะนำ:</h5>
                    <p class="text-xs text-blue-600 leading-relaxed mt-1">รหัสผ่านที่ดีควรประกอบด้วยตัวอักษรพิมพ์ใหญ่
                        พิมพ์เล็ก ตัวเลข และอักขระพิเศษ เพื่อความปลอดภัยสูงสุด</p>
                </div>
            </div>
        </div>
    </main>
</div>