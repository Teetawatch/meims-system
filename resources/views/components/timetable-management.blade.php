<div class="min-h-screen bg-slate-50 font-['Outfit','Anuphan'] flex">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">จัดการตารางเรียน</h1>
                <p class="text-slate-500">อัปโหลดและจัดการไฟล์ตารางเรียน (PDF) และผูกกับหลักสูตร</p>
            </div>

            <button wire:click="openModal"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                อัปโหลดตารางเรียน
            </button>
        </header>

        <!-- Search -->
        <div class="mb-6">
            <input type="text" wire:model.live="search" placeholder="ค้นหาชื่อตารางเรียน, ชื่อหลักสูตร..."
                class="max-w-md w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-sm">
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($timetables as $timetable)
                <div
                    class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-md transition-all group flex flex-col h-full relative">
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3 z-10 flex gap-2">
                        @if($timetable->is_active)
                            <span class="bg-emerald-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg">Active</span>
                        @else
                            <span class="bg-slate-400 text-white text-[10px] font-bold px-2 py-1 rounded-lg">Hidden</span>
                        @endif
                    </div>

                    <!-- Preview Area -->
                    <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent"></div>
                        <svg class="w-16 h-16 text-red-500 drop-shadow-sm group-hover:scale-110 transition-transform duration-300"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 16H8v-2h3v2zm0-4H8V6h3v8zm6 4h-3v-2h3v2zm0-4h-3V6h3v8z"
                                opacity=".2" />
                            <path
                                d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM4 18V6h16v12H4z" />
                            <path d="M8 8h8v8H8z" />
                        </svg>
                        <!-- Mockup view button overlay -->
                        <a href="{{ asset('storage/' . $timetable->file_path) }}" target="_blank"
                            class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span
                                class="bg-white text-slate-800 px-4 py-2 rounded-full text-sm font-bold shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform">
                                เปิดไฟล์ PDF
                            </span>
                        </a>
                        <!-- Course Tag -->
                        @if($timetable->course)
                            <div
                                class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-bold text-slate-700 shadow-sm border border-slate-200">
                                {{ $timetable->course->course_code }}
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg text-slate-800 line-clamp-2 leading-tight">{{ $timetable->title }}
                            </h3>
                            <div class="relative ml-2" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false"
                                    class="text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                    </svg>
                                </button>
                                <div x-show="open"
                                    class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-10"
                                    style="display: none;">
                                    <button wire:click="edit({{ $timetable->id }})"
                                        class="block w-full text-left px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600">แก้ไข</button>
                                    <button wire:click="confirmDelete({{ $timetable->id }})"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">ลบ</button>
                                </div>
                            </div>
                        </div>

                        @if($timetable->course)
                            <p class="text-blue-600 text-xs font-bold mb-2 uppercase tracking-wide">
                                {{ $timetable->course->course_name_th }}</p>
                        @else
                            <p class="text-slate-400 text-xs mb-2">ไม่ระบุหลักสูตร</p>
                        @endif

                        <p class="text-slate-500 text-sm mb-4 line-clamp-3 flex-1">{{ $timetable->description ?? '-' }}</p>

                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center text-xs text-slate-400">
                            <span>อัปโหลดเมื่อ</span>
                            <span>{{ $timetable->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div
                        class="bg-white rounded-full w-20 h-20 mx-auto flex items-center justify-center mb-4 shadow-sm border border-slate-100">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-slate-500 font-medium">ยังไม่มีตารางเรียน</h3>
                    <p class="text-slate-400 text-sm mt-1">กดปุ่ม "อัปโหลดตารางเรียน" เพื่อเริ่มต้น</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $timetables->links() }}
        </div>

    </main>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true"
                    wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full relative z-[101]">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-xl leading-6 font-bold text-slate-900 mb-6" id="modal-title">
                            {{ $isEditMode ? 'แก้ไขตารางเรียน' : 'อัปโหลดตารางเรียนใหม่' }}
                        </h3>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">ชื่อตารางเรียน <span
                                        class="text-red-500">*</span></label>
                                <input type="text" wire:model="title" placeholder="เช่น ตารางเรียน ม.6/1 เทอม 1/2569"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">หลักสูตร <span
                                        class="text-red-500">*</span></label>
                                <select wire:model="course_id"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                    <option value="">-- เลือกหลักสูตร --</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_code }} -
                                            {{ $course->course_name_th }}</option>
                                    @endforeach
                                </select>
                                @error('course_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-slate-700">แสดงผลในหน้าต่างนักเรียน (Active)</span>
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">รายละเอียด (Optional)</label>
                                <textarea wire:model="description" rows="3"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"></textarea>
                                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">ไฟล์ PDF
                                    {{ $isEditMode ? '(ปล่อยว่างหากไม่ต้องการเปลี่ยน)' : '<span class="text-red-500">*</span>' }}</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 transition-colors {{ $pdfFile ? 'bg-blue-50 border-blue-300' : '' }}">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <label for="file-upload"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>เลือกไฟล์ PDF</span>
                                                <input id="file-upload" wire:model="pdfFile" type="file"
                                                    accept="application/pdf" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-slate-500">PDF up to 10MB</p>
                                    </div>
                                </div>
                                @if ($pdfFile)
                                    <p class="text-sm text-blue-600 mt-2 text-center">✓ เลือกไฟล์แล้ว:
                                        {{ $pdfFile->getClientOriginalName() }}</p>
                                @endif
                                @error('pdfFile') <span
                                class="text-red-500 text-xs mt-1 block text-center">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="save" wire:loading.attr="disabled"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            <span wire:loading.remove>บันทึก</span>
                            <span wire:loading>กำลังอัปโหลด...</span>
                        </button>
                        <button type="button" wire:click="closeModal"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            ยกเลิก
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>