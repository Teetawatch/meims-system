<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel + Alpine + Tailwind v4</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-background text-text">
    <div class="relative flex justify-center items-center min-h-screen">
        @if (Route::has('login'))
            <div class="fixed top-0 right-0 p-6 text-right z-50">
                @auth
                    <a href="{{ url('/home') }}"
                        class="font-semibold text-primary hover:text-secondary transition-colors">Home</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-secondary transition-colors">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-primary hover:text-secondary transition-colors">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full">
            <div class="text-center">
                <h1 class="text-5xl font-heading font-bold text-primary mb-4">
                    Healthcare Information System
                </h1>
                <p class="text-lg text-text/80 max-w-2xl mx-auto">
                    A premium, high-performance medical equipment and information management system built with Tailwind
                    CSS v4 and Alpine.js.
                </p>
            </div>

            <!-- Alpine.js Test Component -->
            <div x-data="{ open: false }" class="mt-12 text-center">
                <button @click="open = !open"
                    class="px-8 py-3 bg-cta text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all cursor-pointer">
                    Check System Status
                </button>

                <div class="mt-4">
                    <a href="{{ route('student.register') }}"
                        class="inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all cursor-pointer">
                        ลงทะเบียนนักเรียน (Student Registration)
                    </a>
                </div>

                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    class="mt-6 p-6 bg-white rounded-2xl shadow-xl border border-border max-w-md mx-auto">
                    <div class="flex items-center justify-center gap-3 text-cta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-bold text-xl">System Ready</span>
                    </div>
                    <p class="mt-2 text-text/70">
                        Alpine.js is successfully integrated and working with Tailwind CSS v4.
                    </p>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Cards -->
                <div class="p-8 bg-white rounded-3xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Equipment Tracking</h3>
                    <p class="text-text/60">Real-time monitoring of critical medical assets across all departments.</p>
                </div>

                <div class="p-8 bg-white rounded-3xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div
                        class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Inventory Management</h3>
                    <p class="text-text/60">Automated supply chain and stock management for medical consumables.</p>
                </div>

                <div class="p-8 bg-white rounded-3xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-cta/10 rounded-xl flex items-center justify-center text-cta mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Advanced Analytics</h3>
                    <p class="text-text/60">Comprehensive reporting and data-driven insights for hospital management.
                    </p>
                </div>
            </div>

            <div class="mt-24 text-center text-sm text-text/40">
                <p>MEIMS &copy; {{ date('Y') }} | Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}
                </p>
            </div>
        </div>
    </div>
</body>

</html>