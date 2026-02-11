<div>
    <div class="mb-6 flex justify-between items-center px-6 pt-6">
        <h2 class="text-2xl font-bold text-slate-800">จัดการ Hero Banner</h2>
        <button wire:click="create"
            class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-bold flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            เพิ่มแบนเนอร์ใหม่
        </button>
    </div>

    <!-- Banner Table -->
    <div class="px-6 pb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ลำดับ</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">รูปภาพ</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">หัวข้อ</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ลิงก์</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">สถานะ</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($banners as $banner)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-600">{{ $banner->sort_order }}</td>
                                <td class="px-6 py-4">
                                    <div class="w-32 h-16 rounded-lg overflow-hidden border border-slate-200">
                                        <img src="{{ asset('images/banners/' . str_replace('banners/', '', $banner->image_path)) }}" class="w-full h-full object-cover" alt="{{ $banner->title }}">
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-slate-700">{{ $banner->title ?: '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($banner->link_url)
                                        <a href="{{ $banner->link_url }}" target="_blank" class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1">
                                            เปิดลิงก์
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleStatus({{ $banner->id }})" 
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $banner->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $banner->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        {{ $banner->is_active ? 'เปิดใช้งาน' : 'บันทึก' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="edit({{ $banner->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $banner->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <svg class="w-16 h-16 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-lg font-medium">ยังไม่มีแบนเนอร์ในระบบ</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($banners->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $banners->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden" @click.away="showModal = false">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">{{ $isEdit ? 'แก้ไขแบนเนอร์' : 'เพิ่มแบนเนอร์ใหม่' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Image Preview -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">รูปภาพแบนเนอร์ <span class="text-red-500">*</span></label>
                        <div class="relative w-full h-48 bg-slate-100 rounded-xl overflow-hidden border-2 border-dashed border-slate-200 group">
                            @if($image)
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($existingImage)
                                <img src="{{ asset('images/banners/' . str_replace('banners/', '', $existingImage)) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-xs">คลิกเพื่อเลือกไฟล์รูปภาพ (แนะนำ 1200x400)</span>
                                </div>
                            @endif
                            <input type="file" wire:model="image" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                        @error('image') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">หัวข้อประกาศ (ไม่ระบุก็ได้)</label>
                        <input type="text" wire:model="title" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="เช่น กิจกรรมวันไหว้ครู">
                    </div>

                    <!-- Link URL -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">ลิงก์ URL (ถ้ามี)</label>
                        <input type="url" wire:model="link_url" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="https://example.com/...">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Sort Order -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">ลำดับการแสดงผล</label>
                            <input type="number" wire:model="sort_order" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        </div>
                        <!-- Status -->
                        <div class="flex items-end pb-2">
                             <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="is_active" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                                <span class="text-sm font-bold text-slate-700">เปิดใช้งาน</span>
                             </label>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 text-slate-600 font-bold hover:bg-slate-200 rounded-xl transition-colors">ยกเลิก</button>
                    <button wire:click="save" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md transition-all active:scale-95">
                        {{ $isEdit ? 'บันทึกการแก้ไข' : 'เพิ่มแบนเนอร์' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
