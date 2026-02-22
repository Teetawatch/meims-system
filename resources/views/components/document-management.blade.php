<div class="min-h-screen bg-slate-50 font-sans flex">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">จัดการคลังเอกสาร</h1>
                <p class="text-slate-500">อัปโหลดแฟ้มสะสมงาน คู่มือ และแบบฟอร์มต่างๆ สำหรับนักเรียน</p>
            </div>

            <button wire:click="openModal"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-indigo-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                เพิ่มเอกสารใหม่
            </button>
        </header>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <div class="flex-1 max-w-md relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live="search" placeholder="ค้นหาชื่อเอกสาร..."
                    class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all shadow-sm">
            </div>
            
            <select wire:model.live="categoryFilter"
                class="bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                <option value="">ทุกหมวดหมู่</option>
                <option value="General">ทั่วไป (General)</option>
                <option value="Handbook">คู่มือนักเรียน (Handbook)</option>
                <option value="Form">แบบฟอร์ม (Form)</option>
                <option value="Course Material">เอกสารประกอบการเรียน (Course Material)</option>
            </select>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($documents as $doc)
                <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-indigo-500/5 transition-all group flex flex-col h-full relative">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        @if($doc->is_active)
                            <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2 py-0.5 rounded-full ring-1 ring-emerald-500/10">Active</span>
                        @else
                            <span class="bg-slate-100 text-slate-400 text-[10px] font-bold px-2 py-0.5 rounded-full ring-1 ring-slate-400/10">Hidden</span>
                        @endif
                    </div>

                    <!-- Icon Area -->
                    <div class="p-8 bg-slate-50/50 flex items-center justify-center border-b border-slate-50 relative">
                        @php
                            $iconColor = match($doc->file_type) {
                                'PDF' => 'text-red-500',
                                'DOC', 'DOCX' => 'text-blue-500',
                                'XLS', 'XLSX' => 'text-emerald-500',
                                'PPT', 'PPTX' => 'text-orange-500',
                                default => 'text-slate-400'
                            };
                        @endphp
                        <div class="{{ $iconColor }} group-hover:scale-110 transition-transform duration-300 drop-shadow-sm">
                             @if($doc->file_type == 'PDF')
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 16H8v-2h3v2zm0-4H8V6h3v8zm6 4h-3v-2h3v2zm0-4h-3V6h3v8z" opacity=".2"/><path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM4 18V6h16v12H4z"/><path d="M8 8h8v8H8z"/></svg>
                             @else
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M17 2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H7V4h10v16zM8 6h8v2H8V6zm0 4h8v2H8v-2zm0 4h5v2H8v-2z"/></svg>
                             @endif
                        </div>
                        
                        <!-- File Type Tag -->
                        <div class="absolute bottom-4 right-4">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $doc->file_type }}</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">{{ $doc->category }}</span>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                </button>
                                <div x-show="open" x-transition class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-20">
                                    <button wire:click="edit({{ $doc->id }})" class="block w-full text-left px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">แก้ไข</button>
                                    <button wire:click="confirmDelete({{ $doc->id }})" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">ลบ</button>
                                </div>
                            </div>
                        </div>

                        <h3 class="font-bold text-slate-800 line-clamp-1 mb-1">{{ $doc->title }}</h3>
                        
                        @if($doc->course)
                            <div class="flex items-center gap-1.5 mb-3">
                                <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                                <span class="text-[10px] font-bold text-slate-400 truncate">{{ $doc->course->course_name_th }}</span>
                            </div>
                        @endif

                        <p class="text-slate-500 text-xs mb-6 line-clamp-2 leading-relaxed flex-1">{{ $doc->description ?? 'ไม่มีรายละเอียด' }}</p>

                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                                {{ $doc->file_size }}
                            </div>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                class="inline-flex items-center px-4 py-1.5 bg-slate-900 text-white text-[10px] font-bold rounded-lg hover:bg-black transition-colors">
                                ดาวน์โหลด
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div class="bg-white rounded-full w-20 h-20 mx-auto flex items-center justify-center mb-6 shadow-sm border border-slate-100">
                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-slate-400 font-bold text-xl">ยังไม่มีเอกสารในคลัง</h3>
                    <p class="text-slate-400 text-sm mt-2">กดปุ่ม "เพิ่มเอกสารใหม่" เพื่อเริ่มสร้างคลังเอกสารของคุณ</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $documents->links() }}
        </div>

    </main>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-[100] overflow-y-auto" x-data x-init="$el.focus()">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full relative z-[101]">
                    <div class="bg-white px-8 pt-10 pb-4">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                                {{ $isEditMode ? 'แก้ไขข้อมูลเอกสาร' : 'เพิ่มเอกสารใหม่เข้าคลัง' }}
                            </h3>
                            <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">ชื่อเอกสาร <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="title" placeholder="เช่น คู่มือนักเรียน ประจำปี 2567"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all placeholder:text-slate-300">
                                @error('title') <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <!-- Category -->
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">หมวดหมู่ <span class="text-red-500">*</span></label>
                                    <select wire:model="category"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                                        <option value="General">ทั่วไป</option>
                                        <option value="Handbook">คู่มือนักเรียน</option>
                                        <option value="Form">แบบฟอร์ม</option>
                                        <option value="Course Material">เอกสารรายวิชา</option>
                                    </select>
                                    @error('category') <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Course -->
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">หลักสูตร (ถ้ามี)</label>
                                    <select wire:model="course_id"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                                        <option value="">ทุกหลักสูตร</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->course_code }}</option>
                                        @endforeach
                                    </select>
                                    @error('course_id') <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">รายละเอียดเพิ่มเติม</label>
                                <textarea wire:model="description" rows="3" placeholder="ระบุรายละเอียดสั้นๆ เกี่ยวกับไฟล์นี้..."
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all placeholder:text-slate-300"></textarea>
                            </div>

                            <!-- Active Toggle -->
                            <div class="flex items-center px-1">
                                <label class="relative inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    <span class="ml-3 text-sm font-bold text-slate-600 group-hover:text-slate-800 transition-colors">เปิดแสดงผลทันที (Active)</span>
                                </label>
                            </div>

                            <!-- File Upload -->
                            <div class="pt-4">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">ไฟล์เอกสาร (PDF, Word, Excel) <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-[1.5rem] hover:border-indigo-400 hover:bg-slate-50 transition-all {{ $file ? 'bg-indigo-50 border-indigo-400' : '' }}">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <label for="file-upload-doc" class="relative cursor-pointer bg-white rounded-md font-bold text-indigo-600 hover:text-indigo-500">
                                                <span>{{ $file ? 'เปลี่ยนไฟล์' : 'เลือกไฟล์จากเครื่อง' }}</span>
                                                <input id="file-upload-doc" wire:model="file" type="file" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-[10px] text-slate-400 font-bold">PDF, DOC, XLS up to 20MB</p>
                                    </div>
                                </div>
                                @if ($file)
                                    <div class="mt-4 p-3 bg-indigo-50 rounded-xl flex items-center gap-3">
                                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-indigo-600 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div class="flex-1 overflow-hidden">
                                            <p class="text-xs font-bold text-indigo-900 truncate">{{ $file->getClientOriginalName() }}</p>
                                            <p class="text-[10px] text-indigo-400 uppercase">{{ number_format($file->getSize() / 1024, 0) }} KB</p>
                                        </div>
                                    </div>
                                @elseif($isEditMode && $existingFilePath)
                                    <div class="mt-4 p-3 bg-slate-50 rounded-xl flex items-center gap-3 border border-slate-100">
                                         <span class="text-[10px] font-bold text-slate-400 ml-1 italic">ไฟล์เดิม: {{ basename($existingFilePath) }}</span>
                                    </div>
                                @endif
                                @error('file') <span class="text-red-500 text-xs mt-2 block text-center font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-50/50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-3">
                        <button type="button" wire:click="save" wire:loading.attr="disabled"
                            class="w-full sm:w-auto inline-flex justify-center rounded-2xl px-8 py-3 bg-indigo-600 text-sm font-black text-white hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transform active:scale-95 transition-all">
                            <span wire:loading.remove>{{ $isEditMode ? 'อัปเดตข้อมูล' : 'บันทึกเข้าคลัง' }}</span>
                            <span wire:loading>กำลังดำเนินการ...</span>
                        </button>
                        <button type="button" wire:click="closeModal"
                            class="w-full sm:w-auto inline-flex justify-center rounded-2xl px-8 py-3 bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                            ยกเลิก
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
