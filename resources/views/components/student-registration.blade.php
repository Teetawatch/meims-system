<div class="min-h-screen bg-slate-50 p-4 md:p-12 font-['Outfit','Anuphan',sans-serif] relative overflow-hidden">

    <!-- Premium Animated Background -->
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
        <div
            class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-blue-100/30 rounded-full mix-blend-multiply filter blur-[120px] animate-pulse">
        </div>
        <div
            class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-indigo-100/30 rounded-full mix-blend-multiply filter blur-[120px] animate-pulse animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-[10%] left-[20%] w-[40%] h-[40%] bg-rose-100/30 rounded-full mix-blend-multiply filter blur-[120px] animate-pulse animation-delay-4000">
        </div>
        <div
            class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.12] brightness-100">
        </div>
    </div>

    <!-- Header Section -->
    <div class="max-w-6xl mx-auto mb-12 text-center relative z-10">
        <div
            class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-xl mb-6 border border-slate-100 transform -rotate-3 hover:rotate-0 transition-transform duration-500">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight mb-4 leading-tight">
            ระบบลงทะเบียนนักเรียนใหม่
        </h1>
        <div class="flex items-center justify-center gap-3">
            <span class="h-px w-8 bg-slate-200"></span>
            <p class="text-slate-500 font-bold uppercase tracking-[0.2em] text-[10px]">MEIMS Registration Portal</p>
            <span class="h-px w-8 bg-slate-200"></span>
        </div>
    </div>

    <div
        class="max-w-6xl mx-auto bg-white/70 backdrop-blur-3xl rounded-[3.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.08)] border border-white relative overflow-hidden z-10">

        <!-- Progress Bar (Thin & Elegant) -->
        <div class="bg-slate-100/50 h-1.5 w-full">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-1.5 transition-all duration-700 ease-in-out shadow-[0_0_20px_rgba(37,99,235,0.4)]"
                style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
        </div>

        <div class="p-8 md:p-14">
            <!-- Step Indicators (Bento Style) -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-16">
                @php
                    $stepNames = ['ข้อมูลบัญชี', 'บุคคล', 'ที่อยู่', 'ครอบครัว', 'การศึกษา', 'สุขภาพ'];
                    $stepIcons = [
                        'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                        'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14',
                        'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                        'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                        'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                        'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-7.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                    ];
                @endphp
                @foreach(range(1, $totalSteps) as $step)
                    <div class="relative group cursor-pointer" wire:click="$set('currentStep', {{ $step }})">
                        <div
                            class="px-4 py-5 rounded-2xl border-2 transition-all duration-500 overflow-hidden relative {{ $currentStep >= $step ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-slate-50 border-slate-100 text-slate-400 hover:bg-white hover:border-blue-200' }}">
                            <div class="flex flex-col items-center gap-2 relative z-10">
                                <svg class="w-6 h-6 transform transition-transform group-hover:scale-110" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $stepIcons[$step - 1] }}"></path>
                                </svg>
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest">{{ $stepNames[$step - 1] }}</span>
                            </div>
                            @if($currentStep > $step)
                                <div class="absolute top-2 right-2">
                                    <svg class="w-4 h-4 text-white/50" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <form wire:submit.prevent="save" class="space-y-12">

                <!-- Step 1: Account & General -->
                @if($currentStep == 1)
                    <div class="space-y-10 animate-fade-in-up">
                        <div class="flex items-center gap-6 pb-6 border-b border-slate-50">
                            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5l-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">ข้อมูลบัญชีและระเบียนเบื้องต้น
                                </h3>
                                <p class="text-sm text-slate-400 font-bold uppercase tracking-widest uppercase">Step 01 •
                                    Account Configuration</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Photo Upload (Large & Center) -->
                            <div class="col-span-full mb-6">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="relative group p-1 bg-white border-2 border-dashed border-slate-200 rounded-[3rem] transition-all hover:border-blue-400">
                                        <div class="relative w-40 h-40 bg-slate-50 rounded-[2.8rem] overflow-hidden group">
                                            @if ($photo)
                                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="flex flex-col items-center justify-center h-full text-slate-300">
                                                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Upload
                                                        Photo</span>
                                                </div>
                                            @endif
                                            <label
                                                class="absolute inset-0 bg-blue-600/60 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 cursor-pointer">
                                                <div
                                                    class="flex flex-col items-center text-white scale-90 group-hover:scale-100 transition-transform">
                                                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                        </path>
                                                    </svg>
                                                    <span
                                                        class="font-black text-xs uppercase tracking-widest">อัปโหลดรูป</span>
                                                </div>
                                                <input type="file" wire:model="photo" class="hidden">
                                            </label>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        รูปชุดเครื่องแบบหน้าตรง</p>
                                </div>
                            </div>

                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600 transition-colors">Username</label>
                                <input type="text" wire:model="state.username" placeholder="ตั้งชื่อผู้ใช้"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600 transition-colors">Password</label>
                                <input type="password" wire:model="state.password" placeholder="••••••••"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600 transition-colors">รหัสนักเรียน</label>
                                <input type="text" wire:model="state.student_id" placeholder="รหัสจากกองการเรียน"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600 transition-colors">รุ่น
                                    / Batch</label>
                                <input type="text" wire:model="state.batch"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600 transition-colors">ปีงบประมาณ</label>
                                <input type="text" wire:model="state.fiscal_year"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600 transition-colors">เลขบัตรประชาชน</label>
                                <input type="text" wire:model="state.id_card_number"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600 transition-colors">เพศ</label>
                                <select wire:model="state.gender"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold appearance-none cursor-pointer">
                                    <option value="">เลือกเพศ</option>
                                    <option value="Male">ชาย</option>
                                    <option value="Female">หญิง</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step 2: Personal Info -->
                @if($currentStep == 2)
                    <div class="space-y-10 animate-fade-in-up">
                        <div class="flex items-center gap-6 pb-6 border-b border-slate-50">
                            <div
                                class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">ข้อมูลส่วนตัวและอัตลักษณ์</h3>
                                <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">Step 02 • Personal
                                    Identification</p>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <h4
                                class="text-xs font-black text-blue-600 uppercase tracking-[0.2em] border-l-4 border-blue-600 pl-4">
                                ชื่อ - นามสกุล (ภาษาไทย)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">คำนำหน้า</label>
                                    <input type="text" wire:model="state.title_th" placeholder="นาย, จ่าตรี, จ่าโท"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">ชื่อ
                                        (ไทย)</label>
                                    <input type="text" wire:model="state.first_name_th"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">นามสกุล
                                        (ไทย)</label>
                                    <input type="text" wire:model="state.last_name_th"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                            </div>

                            <h4
                                class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] border-l-4 border-indigo-600 pl-4">
                                Full Name (English)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">Title
                                        (EN)</label>
                                    <input type="text" wire:model="state.title_en" placeholder="Mr., PO3, PO2"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">First
                                        Name</label>
                                    <input type="text" wire:model="state.first_name_en"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">Last
                                        Name</label>
                                    <input type="text" wire:model="state.last_name_en"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                            </div>

                            <h4
                                class="text-xs font-black text-rose-600 uppercase tracking-[0.2em] border-l-4 border-rose-600 pl-4">
                                ข้อมูลเบื้องลึก</h4>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">วัน/เดือน/ปีเกิด</label>
                                    <input type="date" wire:model="state.birth_date"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">หมู่โลหิต</label>
                                    <input type="text" wire:model="state.blood_type"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">ศาสนา</label>
                                    <input type="text" wire:model="state.religion"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                                <div class="space-y-1 relative group">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 group-focus-within:text-blue-600">เชื้อชาติ</label>
                                    <input type="text" wire:model="state.race"
                                        class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step 3: Contact & Address -->
                @if($currentStep == 3)
                    <div class="space-y-10 animate-fade-in-up">
                        <div class="flex items-center gap-6 pb-6 border-b border-slate-50">
                            <div
                                class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">
                                    ข้อมูลถิ่นที่อยู่และช่องทางติดต่อ</h3>
                                <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">Step 03 • Contact &
                                    Address</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">เบอร์โทรศัพท์</label>
                                <input type="text" wire:model="state.phone"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">อีเมล</label>
                                <input type="email" wire:model="state.email"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="form-group lg:col-span-3">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">ที่อยู่ปัจจุบันโดยละเอียด</label>
                                <textarea wire:model="state.current_address" rows="3"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-[2rem] focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold mt-2 outline-none"></textarea>
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">ตำบล/แขวง</label>
                                <input type="text" wire:model="state.subdistrict"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">อำเภอ/เขต</label>
                                <input type="text" wire:model="state.district"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">จังหวัด</label>
                                <input type="text" wire:model="state.province"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step 4: Family -->
                @if($currentStep == 4)
                    <div class="space-y-10 animate-fade-in-up">
                        <div class="flex items-center gap-6 pb-6 border-b border-slate-50">
                            <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">ข้อมูลครอบครัวและผู้ปกครอง
                                </h3>
                                <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">Step 04 • Family
                                    Information</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                            <div
                                class="bg-blue-50/30 p-8 rounded-[3rem] border border-blue-50 relative overflow-hidden group">
                                <div
                                    class="absolute top-0 right-0 p-8 opacity-10 transform translate-x-4 -translate-y-4 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-700">
                                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-black text-blue-800 mb-8 flex items-center mx-auto">
                                    <span
                                        class="w-8 h-8 bg-blue-100 rounded-xl flex items-center justify-center mr-3 text-sm">บ</span>
                                    บิดา
                                </h4>
                                <div class="space-y-6">
                                    <input type="text" wire:model="state.father_name" placeholder="ชื่อ-นามสกุลบิดา"
                                        class="w-full px-6 py-4 bg-white border-none rounded-2xl shadow-sm font-bold">
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="number" wire:model="state.father_age" placeholder="อายุ"
                                            class="w-full px-6 py-4 bg-white border-none rounded-2xl shadow-sm font-bold">
                                        <input type="text" wire:model="state.father_occupation" placeholder="อาชีพ"
                                            class="w-full px-6 py-4 bg-white border-none rounded-2xl shadow-sm font-bold">
                                    </div>
                                    <input type="number" wire:model="state.father_income"
                                        placeholder="รายได้ประมาณการ / เดือน"
                                        class="w-full px-6 py-4 bg-white border-none rounded-2xl shadow-sm font-bold">
                                </div>
                            </div>

                            <div
                                class="bg-rose-50/30 p-8 rounded-[3rem] border border-rose-50 relative overflow-hidden group">
                                <div
                                    class="absolute top-0 right-0 p-8 opacity-10 transform translate-x-4 -translate-y-4 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-700">
                                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-black text-rose-800 mb-8 flex items-center">
                                    <span
                                        class="w-8 h-8 bg-rose-100 rounded-xl flex items-center justify-center mr-3 text-sm">ม</span>
                                    มารดา
                                </h4>
                                <div class="space-y-6">
                                    <input type="text" wire:model="state.mother_name" placeholder="ชื่อ-นามสกุลมารดา"
                                        class="w-full px-6 py-4 bg-white border-none rounded-2xl shadow-sm font-bold">
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="number" wire:model="state.mother_age" placeholder="อายุ"
                                            class="w-full px-6 py-4 bg-white border-none rounded-2xl shadow-sm font-bold">
                                        <input type="text" wire:model="state.mother_occupation" placeholder="อาชีพ"
                                            class="w-full px-6 py-4 bg-white border-none rounded-2xl shadow-sm font-bold">
                                    </div>
                                    <input type="number" wire:model="state.mother_income"
                                        placeholder="รายได้ประมาณการ / เดือน"
                                        class="w-full px-6 py-4 bg-white border-none rounded-2xl shadow-sm font-bold">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step 5: Education -->
                @if($currentStep == 5)
                    <div class="space-y-10 animate-fade-in-up">
                        <div class="flex items-center gap-6 pb-6 border-b border-slate-50">
                            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">ข้อมูลการศึกษาและวิชาการ</h3>
                                <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">Step 05 • Academic
                                    Background</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">วันที่เเข้าศึกษา
                                    (ครั้งแรก)</label>
                                <input type="date" wire:model="state.enrollment_date"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">วุฒิการศึกษาเดิม</label>
                                <input type="text" wire:model="state.degree_level" placeholder="เช่น ม.6, ปวช."
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group md:col-span-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">หลักสูตร
                                    / สาขาวิชา</label>
                                <input type="text" wire:model="state.course_name"
                                    placeholder="ระบุชื่อหลักสูตรที่กำลังศึกษา"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step 6: Health -->
                @if($currentStep == 6)
                    <div class="space-y-10 animate-fade-in-up">
                        <div class="flex items-center gap-6 pb-6 border-b border-slate-50">
                            <div
                                class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">ข้อมูลสุขภาพและพันธกิจ</h3>
                                <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">Step 06 • Medical &
                                    Health Record</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-1 relative group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">น้ำหนัก
                                    (กิโลกรัม)</label>
                                <input type="number" step="0.1" wire:model="state.weight"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="space-y-1 relative group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">ส่วนสูง
                                    (เซนติเมตร)</label>
                                <input type="number" step="0.1" wire:model="state.height"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold">
                            </div>
                            <div class="lg:col-span-2">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">โรคประจำตัว
                                    หรือประวัติการแพ้ยา</label>
                                <textarea wire:model="state.chronic_diseases" rows="3"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-50 rounded-[2rem] focus:bg-white focus:border-blue-500 shadow-sm transition-all font-bold mt-2 outline-none"></textarea>
                            </div>
                        </div>

                        <!-- Final Message -->
                        <div class="bg-slate-900 p-10 rounded-[3rem] text-white overflow-hidden relative group">
                            <div class="relative z-10">
                                <h4 class="text-2xl font-black mb-3 italic">"ความถูกต้องของข้อมูลคือสิ่งสำคัญ"</h4>
                                <p class="text-slate-400 font-bold text-sm max-w-lg italic">
                                    กรุณาตรวจสอบข้อมูลทั้งหมดที่ท่านกรอกอย่างละเอียด
                                    ข้อมูลเหล่านี้จะถูกใช้เป็นระเบียนประวัติตลอดระยะเวลาการศึกษา</p>
                            </div>
                            <div
                                class="absolute -bottom-8 -right-8 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-colors duration-1000">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Elegant Navigation Buttons -->
                <div class="mt-16 flex justify-between items-center pt-10 border-t border-slate-100">
                    <button type="button" wire:click="prevStep"
                        class="px-8 py-4 rounded-2xl border border-slate-200 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:text-slate-900 transition-all active:scale-95 flex items-center gap-2 {{ $currentStep == 1 ? 'invisible' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        ย้อนกลับ
                    </button>

                    <div class="flex items-center gap-4">
                        @if($currentStep < $totalSteps)
                            <button type="button" wire:click="nextStep"
                                class="px-10 py-4 rounded-2xl bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/10 hover:bg-black hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-3 group">
                                ขั้นตอนถัดไป
                                <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @else
                            <button type="submit"
                                class="px-12 py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-700 text-white font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-emerald-600/20 hover:shadow-emerald-600/40 hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                ยืนยันข้อมูลทั้งหมด
                            </button>
                        @endif
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Final Footer Branding -->
    <div class="max-w-6xl mx-auto mt-12 mb-20 text-center opacity-40">
        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">Logistics Management Information
            System • Version 4.0.2</p>
    </div>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-pulse {
            animation: pulse 12s infinite ease-in-out;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.5;
            }
        }
    </style>
</div>