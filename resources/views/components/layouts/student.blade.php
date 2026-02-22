<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'ระบบบริหารจัดการนักเรียน - Dashboard' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-slate-50 font-sans antialiased">

    @if(Route::is('student.login'))
        {{ $slot }}
    @else
        <div x-data="{ sidebarOpen: false }" @open-sidebar.window="sidebarOpen = true" class="flex min-h-screen relative">
            <!-- Mobile Backdrop -->
            <div x-show="sidebarOpen" 
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                @click="sidebarOpen = false"
                class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 lg:hidden"></div>
        
            <!-- Sidebar Container -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">
                <x-student-sidebar />
            </aside>
        
            <!-- Main Content Area -->
            <div class="flex-1 lg:ml-72 min-h-screen flex flex-col">
                <!-- Top Header (Sticky) -->
                <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-slate-200">
                    <div class="max-w-[1600px] mx-auto px-4 md:px-8 h-16 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                            </button>
                            <h1 class="text-xl font-black text-slate-800 hidden sm:block">MEIMS <span class="text-blue-600">STUDENT</span></h1>
                        </div>

                        <div class="flex items-center gap-4">
                            <livewire:notification-dropdown />
                            
                            <div class="h-8 w-px bg-slate-200"></div>
                            
                            <!-- Account Dropdown -->
                            <div class="relative group" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-slate-50 transition-all">
                                    <span class="text-sm font-bold text-slate-700 hidden md:block">บัญชีผู้ใช้</span>
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" 
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    style="display: none;"
                                    class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50 overflow-hidden">
                                    
                                    <div class="px-4 py-2 border-b border-slate-50 mb-1">
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">ยินดีต้อนรับ</p>
                                        <p class="text-sm font-bold text-slate-800 truncate">
                                            {{ auth('student')->user()?->first_name_th ?? 'นักเรียน' }}
                                        </p>
                                    </div>

                                    <a href="{{ route('student.profile') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        ดูโปรไฟล์
                                    </a>
                                    <a href="{{ route('student.change-password') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m-2 4a2 2 0 012 2m-2-4a2 2 0 012 2m-2 4h.01M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        เปลี่ยนรหัสผ่าน
                                    </a>
                                    
                                    <div class="h-px bg-slate-50 my-1"></div>
                                    
                                    <button onclick="confirmLogout()" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        ออกจากระบบ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @endif


    @livewireScripts
    <!-- Swal Scripts -->
    <script>
        window.addEventListener('swal:modal', event => {
            Swal.fire({
                title: event.detail[0].title,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                confirmButtonColor: '#3b82f6',
                confirmButtonText: 'ตกลง'
            });
        });

        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                title: event.detail[0].title,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.Livewire.dispatch(event.detail[0].method, { id: event.detail[0].id });
                }
            });
        });

        function confirmLogout() {
            Swal.fire({
                title: 'ต้องการออกจากระบบ?',
                text: "คุณจะถูกนำกลับเข้าสู่หน้าเข้าสู่ระบบ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'ยืนยันออกจากระบบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('student.logout') }}";
                }
            })
        }
    </script>
</body>

</html>