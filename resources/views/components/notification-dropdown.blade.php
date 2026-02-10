<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        @if($this->unreadCount > 0)
            <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full animate-pulse">{{ $this->unreadCount }}</span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-slate-100 overflow-hidden z-20" style="display: none;">
        
        <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800">การแจ้งเตือน</h3>
            @if($this->unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-blue-600 hover:underline">อ่านทั้งหมด</button>
            @endif
        </div>

        <div class="divide-y divide-slate-50 max-h-80 overflow-y-auto">
            @forelse($this->notifications as $notification)
                <div class="p-4 hover:bg-slate-50 transition-colors {{ $notification->read_at ? 'opacity-60' : '' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <!-- Icon logic based on type -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 line-clamp-1">{{ $notification->data['title'] ?? 'Title' }}</p>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-0.5">{{ $notification->data['content'] ?? 'No detail' }}</p>
                            <p class="text-[10px] text-slate-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        @if(!$notification->read_at)
                            <button wire:click="markAsRead('{{ $notification->id }}')" class="w-2 h-2 rounded-full bg-blue-500" title="ทำเครื่องหมายว่าอ่านแล้ว"></button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <p class="text-sm">ไม่มีการแจ้งเตือนใหม่</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
