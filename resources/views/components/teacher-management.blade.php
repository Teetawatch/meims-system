<div class="min-h-screen bg-slate-50 font-['Outfit','Anuphan'] flex">
    <x-sidebar />

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">จัดการข้อมูลอาจารย์</h1>
                <p class="text-slate-500 font-medium">จัดการรายชื่ออาจารย์ผู้สอนและการตั้งค่าต่างๆ</p>
            </div>

            <div class="flex gap-3">
                <button wire:click="openModal"
                    class="inline-flex items-center px-6 py-3 bg-slate-900 hover:bg-black text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-slate-900/20 transform active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    เพิ่มอาจารย์ใหม่
                </button>
            </div>
        </header>

        <!-- Search Section -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 mb-8">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live="search" placeholder="ค้นหา ชื่อ-นามสกุล, รหัสอาจารย์..."
                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                อาจารย์</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                ตำแหน่ง</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                ติดต่อ</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                                การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($teachers as $teacher)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 font-black text-sm">
                                            {{ mb_substr($teacher->first_name_th, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">
                                                {{ $teacher->title_th }}{{ $teacher->first_name_th }}
                                                {{ $teacher->last_name_th }}</div>
                                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                {{ $teacher->teacher_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">{{ $teacher->position ?? 'อาจารย์ผู้สอน' }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-xs font-bold text-slate-600">{{ $teacher->email ?? '-' }}</div>
                                    <div class="text-[10px] font-medium text-slate-400">{{ $teacher->phone ?? '-' }}</div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div
                                        class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="edit({{ $teacher->id }})"
                                            class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $teacher->id }})"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold">ไม่พบข้อมูลอาจารย์
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($teachers->hasPages())
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                    {{ $teachers->links() }}
                </div>
            @endif
        </div>
    </main>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-[100] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                    wire:click="$set('isModalOpen', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full relative z-[101]">
                    <div class="px-8 pt-10 pb-6">
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight mb-8">
                            {{ $teacherId ? 'แก้ไขข้อมูลอาจารย์' : 'เพิ่มอาจารย์ใหม่' }}
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">รหัสอาจารย์
                                    <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="teacher_code" placeholder="เช่น T001"
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                @error('teacher_code') <span
                                class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">คำนำหน้า</label>
                                    <input type="text" wire:model="title_th" placeholder="นาย, นาง, ดร."
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                </div>
                                <div class="col-span-1">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">ชื่อ
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="first_name_th"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                    @error('first_name_th') <span
                                    class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">นามสกุล
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="last_name_th"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                    @error('last_name_th') <span
                                    class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">ตำแหน่ง</label>
                                <input type="text" wire:model="position" placeholder="เช่น อาจารย์ประจำสาขา"
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">อีเมล</label>
                                    <input type="email" wire:model="email" placeholder="example@email.com"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                </div>
                                <div>
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">เบอร์โทรศัพท์</label>
                                    <input type="text" wire:model="phone"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50/50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-3">
                        <button type="button" wire:click="save"
                            class="w-full sm:w-auto px-8 py-3 bg-slate-900 text-white text-sm font-black rounded-2xl hover:bg-black transition-all shadow-xl shadow-slate-900/20 transform active:scale-95">
                            บันทึกข้อมูล
                        </button>
                        <button type="button" wire:click="$set('isModalOpen', false)"
                            class="w-full sm:w-auto px-8 py-3 bg-white border border-slate-200 text-sm font-bold text-slate-500 rounded-2xl hover:bg-slate-50 transition-all">
                            ยกเลิก
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>