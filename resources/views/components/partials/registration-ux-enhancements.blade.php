<!-- UX Enhancements Wrapper (Single Root Element for Livewire) -->
<div>
    <!-- Sticky Bottom Navigation Bar (Mobile Friendly) -->
    <div
        class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-xl border-t border-slate-200 shadow-2xl z-50 md:hidden pb-safe">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between gap-3">
                <button type="button" wire:click="prevStep"
                    class="flex-1 px-4 py-3 rounded-xl border-2 border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-all active:scale-95 flex items-center justify-center gap-2 {{ $currentStep == 1 ? 'opacity-50 pointer-events-none' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    ย้อนกลับ
                </button>

                <div class="flex-shrink-0 px-4 py-2 bg-blue-50 rounded-xl">
                    <span class="text-blue-600 font-black text-sm">{{ $currentStep }}/{{ $totalSteps }}</span>
                </div>

                @if($currentStep < $totalSteps)
                    <button type="button" wire:click="nextStep"
                        class="flex-1 px-4 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition-all active:scale-95 flex items-center justify-center gap-2">
                        ถัดไป
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                @else
                    <button type="submit" onclick="document.querySelector('form').submit()"
                        class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-700 text-white font-bold text-sm hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                        ยืนยัน
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Floating Help Button -->
    <div x-data="{ showHelp: false }" class="fixed bottom-24 md:bottom-6 right-6 z-40">
        <button @click="showHelp = !showHelp" type="button"
            class="w-14 h-14 bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-full shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-110 transition-all flex items-center justify-center group">
            <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </button>

        <!-- Help Panel -->
        <div x-show="showHelp" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95" @click.away="showHelp = false"
            class="absolute bottom-16 right-0 w-80 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden"
            x-cloak>

            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 class="text-white font-black text-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    คำแนะนำการใช้งาน
                </h3>
            </div>

            <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-black text-sm">1</span>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">คลิกที่ขั้นตอนด้านบน</p>
                            <p class="text-slate-500 text-xs mt-1">เพื่อกระโดดไปยังขั้นตอนที่ต้องการได้ทันที</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-emerald-600 font-black text-sm">2</span>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">ช่องที่มีเครื่องหมาย *</p>
                            <p class="text-slate-500 text-xs mt-1">คือช่องที่จำเป็นต้องกรอก</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-amber-600 font-black text-sm">3</span>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">ใช้ปุ่มด้านล่าง</p>
                            <p class="text-slate-500 text-xs mt-1">เพื่อนำทางไปยังขั้นตอนถัดไป</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">ข้อความสีแดง</p>
                            <p class="text-slate-500 text-xs mt-1">แสดงข้อผิดพลาดที่ต้องแก้ไข</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <p class="text-xs text-slate-400 text-center">
                        <span class="font-bold">💡 เคล็ดลับ:</span> กด Tab เพื่อข้ามไปช่องถัดไป
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Summary (Desktop Only) -->
    <div class="hidden md:block fixed top-6 right-6 z-30">
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-200 p-4 min-w-[200px]">
            <div class="flex items-center gap-3 mb-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">ความคืบหน้า</p>
                    <p class="text-lg font-black text-slate-900">{{ round(($currentStep / $totalSteps) * 100) }}%</p>
                </div>
            </div>
            <div class="space-y-1">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500 font-medium">ขั้นตอนที่</span>
                    <span class="text-slate-900 font-bold">{{ $currentStep }}/{{ $totalSteps }}</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2 rounded-full transition-all duration-500"
                        style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>