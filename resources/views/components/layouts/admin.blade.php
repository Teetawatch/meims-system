<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'MEIMS System' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">

    <div x-data="{ sidebarOpen: false }" @open-sidebar.window="sidebarOpen = true" class="flex min-h-screen relative">
        <!-- Mobile Backdrop -->
        <div x-show="sidebarOpen" 
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 lg:hidden"></div>
    
        <!-- Sidebar Container -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="w-72 shrink-0 bg-white/95 backdrop-blur-2xl border-r border-slate-200 flex flex-col fixed inset-y-0 left-0 z-40 transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">
            <x-sidebar />
        </aside>
    
        <!-- Main Content Outer Container -->
        <div class="flex-1 lg:ml-72 min-h-screen flex flex-col">
            <main class="flex-1 p-4 md:p-8 relative">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-blue-100/50 rounded-full blur-[80px] md:blur-[100px] -mr-32 md:-mr-64 -mt-32 md:-mt-64 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-indigo-100/40 rounded-full blur-[80px] md:blur-[100px] -ml-24 md:-ml-48 -mb-24 md:-mb-48 pointer-events-none"></div>
    
                <!-- Top Header -->
                <div class="flex items-center justify-between mb-8 relative z-20">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 bg-white text-slate-600 rounded-xl shadow-sm border border-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        </button>
                        <h1 class="text-2xl font-black text-slate-900 hidden sm:block">MEIMS System</h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <livewire:notification-dropdown />
                        
                        <!-- Mini Profile (Optional, relying on Sidebar for full profile) -->
                        <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden hidden sm:block">
                            <svg class="w-full h-full text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Content Slot -->
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
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
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(event.detail[0].method, { id: event.detail[0].id });
                }
            });
        });
    </script>
</body>
</html>
