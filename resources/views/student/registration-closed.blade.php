<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ปิดการลงทะเบียน | MEIMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Anuphan:wght@100..700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-['Outfit','Anuphan',sans-serif] text-slate-800 antialiased overflow-hidden">
    
    <!-- Premium Aurora Background -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-5%] w-[700px] h-[700px] bg-linear-to-br from-blue-400/20 to-indigo-500/15 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[700px] h-[700px] bg-linear-to-tr from-purple-400/20 to-pink-400/15 rounded-full blur-[120px] animate-pulse delay-700"></div>
        <div class="absolute inset-0 bg-white/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-6">
        <div class="max-w-xl w-full text-center">
            <!-- Icon Decoration -->
            <div class="mb-10 relative inline-block group">
                <div class="absolute inset-0 bg-rose-500 blur-2xl opacity-20 group-hover:opacity-40 transition-opacity duration-1000 rounded-full animate-pulse"></div>
                <div class="relative w-24 h-24 bg-white rounded-[2.5rem] shadow-2xl flex items-center justify-center text-rose-500 border border-white group-hover:scale-110 group-hover:rotate-12 transition-all duration-700">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m11-3V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7m4 2a2 2 0 110-4 2 2 0 010 4z"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight leading-tight">
                ขออภัย <br><span class="bg-clip-text text-transparent bg-linear-to-r from-rose-600 to-red-500">ปิดการลงทะเบียน</span>
            </h1>
            
            <p class="text-slate-500 font-bold text-lg mb-12 leading-relaxed max-w-md mx-auto">
                ขณะนี้ระบบยังไม่เปิดให้ลงทะเบียนนักเรียนใหม่ <br>
                หากท่านเป็นนักเรียนปัจจุบัน โปรดเข้าสู่ระบบ <br>
                เพื่อเข้าใช้งานได้ตามปกติครับ
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl shadow-slate-900/20 hover:scale-[1.02] active:scale-95 transition-all group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    กลับสู่หน้าหลัก
                </a>
                
                <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-slate-900 font-black rounded-2xl shadow-lg border border-slate-100 hover:bg-slate-50 active:scale-95 transition-all">
                    เข้าสู่ระบบ
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </a>
            </div>

            <!-- System Info -->
            <div class="mt-20 pt-10 border-t border-slate-200/50">
            </div>
        </div>
    </div>
</body>
</html>
