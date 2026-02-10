<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">จัดการประกาศและข่าวสาร</h2>
        <button wire:click="create"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            สร้างประกาศใหม่
        </button>
    </div>

    <!-- Search -->
    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-slate-100">
        <div class="relative">
            <svg class="w-5 h-5 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" wire:model.live.debounce.300ms="search" 
                class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder:text-slate-400"
                placeholder="ค้นหาหัวข้อประกาศ...">
        </div>
    </div>

    <!-- Announcements Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($announcements as $announcement)
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-shadow group flex flex-col h-full">
                <!-- Header / Type Badge -->
                <div class="p-4 border-b border-slate-50 flex justify-between items-start">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($announcement->type === 'urgent') bg-red-100 text-red-800
                            @elseif($announcement->type === 'activity') bg-green-100 text-green-800
                            @else bg-blue-100 text-blue-800 @endif">
                            @if($announcement->type === 'urgent') ด่วนที่สุด
                            @elseif($announcement->type === 'activity') กิจกรรม
                            @else ข่าวทั่วไป @endif
                        </span>
                        <div class="mt-2 text-xs text-slate-400 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $announcement->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg border border-slate-100 py-1 z-10" style="display: none;">
                            <button wire:click="edit({{ $announcement->id }})" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">แก้ไข</button>
                            <button wire:click="confirmDelete({{ $announcement->id }})" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">ลบ</button>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4 flex-1">
                    <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2" title="{{ $announcement->title }}">{{ $announcement->title }}</h3>
                    <p class="text-slate-500 text-sm line-clamp-3">{{ $announcement->content }}</p>
                    
                    @if($announcement->attachment_path)
                        <div class="mt-4 p-2 bg-slate-50 rounded-lg border border-slate-200 flex items-center gap-3">
                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            <div class="overflow-hidden">
                                <p class="text-xs font-medium text-slate-700 truncate">เอกสารแนบ</p>
                                <a href="{{ asset('storage/' . $announcement->attachment_path) }}" target="_blank" class="text-[10px] text-blue-600 hover:underline truncate block">เปิดดูไฟล์</a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer / Publishing Status -->
                <div class="px-4 py-3 bg-slate-50 border-t border-slate-100 flex justify-between items-center text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $announcement->is_published ? 'bg-green-500' : 'bg-slate-300' }}"></span>
                        <span class="font-medium text-slate-600">{{ $announcement->is_published ? 'เผยแพร่แล้ว' : 'แบบร่าง' }}</span>
                    </div>
                    <div class="flex -space-x-1">
                         <!-- Target Icons -->
                         @if(in_array('students', is_array($announcement->target_audiences) ? $announcement->target_audiences : json_decode($announcement->target_audiences, true) ?? []))
                            <div class="w-6 h-6 rounded-full bg-blue-100 border-2 border-white flex items-center justify-center text-blue-600 text-[10px]" title="นักเรียน">S</div>
                         @endif
                         @if(in_array('guardians', is_array($announcement->target_audiences) ? $announcement->target_audiences : json_decode($announcement->target_audiences, true) ?? []))
                            <div class="w-6 h-6 rounded-full bg-amber-100 border-2 border-white flex items-center justify-center text-amber-600 text-[10px]" title="ผู้ปกครอง">P</div>
                         @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-12 text-slate-400 bg-white rounded-xl border border-dashed border-slate-300">
                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                <p class="text-lg font-medium">ยังไม่มีประกาศข่าวสาร</p>
                <button wire:click="create" class="mt-2 text-sm text-blue-600 hover:underline">สร้างประกาศแรกเลย!</button>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $announcements->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm transition-opacity">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.away="showModal = false">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white z-10">
                    <h3 class="text-lg font-bold text-slate-800">{{ $isEdit ? 'แก้ไขประกาศ' : 'สร้างประกาศใหม่' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">หัวข้อประกาศ <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="title" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder:text-slate-300 placeholder:font-light" placeholder="ระบุหัวข้อที่ต้องการแจ้งให้ทราบ...">
                        @error('title') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">ประเภทประกาศ</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="type" value="general" class="text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-600">ทั่วไป</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="type" value="urgent" class="text-red-600 focus:ring-red-500">
                                <span class="text-sm text-slate-600">ด่วนที่สุด</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="type" value="activity" class="text-green-600 focus:ring-green-500">
                                <span class="text-sm text-slate-600">กิจกรรม/ประชาสัมพันธ์</span>
                            </label>
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">เนื้อหารายละเอียด <span class="text-red-500">*</span></label>
                        <textarea wire:model="content" rows="5" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder:text-slate-300 placeholder:font-light" placeholder="รายละเอียดเนื้อหาประกาศ..."></textarea>
                        @error('content') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Attachment -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">ไฟล์แนบ (ถ้ามี)</label>
                        <div class="flex items-center gap-4">
                            <label class="cursor-pointer bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                เลือกไฟล์...
                                <input type="file" wire:model="attachment" class="hidden">
                            </label>
                            @if($attachment)
                                <span class="text-xs text-green-600 font-medium truncate max-w-[200px]">{{ $attachment->getClientOriginalName() }}</span>
                            @elseif($existingAttachment)
                                <a href="{{ asset('storage/' . $existingAttachment) }}" target="_blank" class="text-xs text-blue-600 hover:underline truncate max-w-[200px]">ไฟล์ปัจจุบัน (คลิกเพื่อดู)</a>
                            @else
                                <span class="text-xs text-slate-400 italic">ยังไม่ได้เลือกไฟล์</span>
                            @endif
                        </div>
                        @error('attachment') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Target Audience -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">กลุ่มเป้าหมาย (แจ้งเตือนไปยัง)</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-blue-50/50 transition-colors @if(in_array('students', $target_audiences)) bg-blue-50 border-blue-200 ring-1 ring-blue-500 @endif">
                                <input type="checkbox" wire:model="target_audiences" value="students" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-slate-700">นักเรียน</span>
                            </label>
                            <label class="flex items-center p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-amber-50/50 transition-colors @if(in_array('guardians', $target_audiences)) bg-amber-50 border-amber-200 ring-1 ring-amber-500 @endif">
                                <input type="checkbox" wire:model="target_audiences" value="guardians" class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500">
                                <span class="ml-3 text-sm font-medium text-slate-700">ผู้ปกครอง</span>
                            </label>
                        </div>
                        @error('target_audiences') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Is Published -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_published" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-slate-700">เผยแพร่ทันที</span>
                        </label>
                        <span class="text-xs text-slate-400">(หากติ๊กเลือก จะมีการส่งแจ้งเตือนไปยังกลุ่มเป้าหมายทันที)</span>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3 bg-slate-50 sticky bottom-0 rounded-b-2xl">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 text-slate-600 font-medium hover:bg-slate-200 rounded-lg transition-colors">ยกเลิก</button>
                    <button wire:click="save" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all transform active:scale-95">
                        {{ $isEdit ? 'บันทึกการแก้ไข' : 'สร้างประกาศ' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
