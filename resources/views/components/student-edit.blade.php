<div>
    {{-- Main Container with Single Root Element --}}
    <div class="min-h-screen bg-slate-50 relative font-['Outfit','Anuphan',sans-serif] overflow-hidden"
        x-data="{ showToast: false, toastMessage: '' }" @validation-error.window="
            toastMessage = $event.detail.message; 
            showToast = true; 
            setTimeout(() => showToast = false, 5000)
         ">

        {{-- Background Effects --}}
        <div class="fixed inset-0 w-full h-full pointer-events-none z-0">
            <div
                class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-amber-400/20 rounded-full blur-[100px] animate-pulse">
            </div>
            <div
                class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-orange-400/20 rounded-full blur-[100px] animate-pulse animation-delay-2000">
            </div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10"></div>
        </div>

        {{-- Content Wrapper --}}
        <div class="relative z-10 max-w-5xl mx-auto px-4 py-8 md:py-12 pb-32">

            {{-- Header --}}
            <div class="text-center mb-10">
                <a href="{{ route('students.show', $student->id) }}"
                    class="inline-flex items-center text-slate-500 hover:text-blue-600 font-medium text-sm mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    กลับไปหน้ารายละเอียด
                </a>
                <div
                    class="inline-flex p-3 bg-white rounded-2xl shadow-lg shadow-amber-500/10 mb-4 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight mb-2">
                    แก้ไขข้อมูลนักเรียน
                </h1>
                <p class="text-slate-500 font-medium text-sm md:text-base">
                    {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }} — {{ $student->student_id }}
                </p>
            </div>

            {{-- Main Validations Alert --}}
            @if($errors->any())
                <div
                    class="mb-8 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-start gap-4 animate-fade-in-down">
                    <div class="bg-red-100 text-red-500 p-2 rounded-xl shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-red-700">พบข้อผิดพลาด</h4>
                        <ul class="mt-1 list-disc list-inside text-sm text-red-600">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Form Card --}}
            <div
                class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-white/50 overflow-hidden">

                {{-- Progress Bar --}}
                <div class="h-1.5 w-full bg-slate-100">
                    <div class="h-full bg-gradient-to-r from-amber-500 to-orange-500 transition-all duration-500 ease-out"
                        style="width: {{ ($currentStep / $totalSteps) * 100 }}%">
                    </div>
                </div>

                <div class="p-6 md:p-10">
                    {{-- Steps Navigation --}}
                    <div class="grid grid-cols-3 md:grid-cols-6 gap-2 md:gap-4 mb-10">
                        @foreach(range(1, $totalSteps) as $step)
                            @php
                                $isActive = $currentStep >= $step;
                                $isCurrent = $currentStep == $step;
                                $icons = [
                                    1 => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                    2 => 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14',
                                    3 => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                                    4 => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                                    5 => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                                    6 => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-7.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                                ];
                                $titles = ['บัญชี', 'บุคคล', 'ที่อยู่', 'ครอบครัว', 'การศึกษา', 'สุขภาพ'];
                            @endphp
                            <button wire:click="$set('currentStep', {{ $step }})"
                                class="flex flex-col items-center justify-center p-3 rounded-2xl border transition-all duration-300 {{ $isActive ? ($isCurrent ? 'bg-amber-600 border-amber-600 text-white shadow-lg scale-105' : 'bg-white border-amber-200 text-amber-600') : 'bg-slate-50 border-transparent text-slate-400 hover:bg-slate-100' }}">
                                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $icons[$step] }}"></path>
                                </svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">{{ $titles[$step - 1] }}</span>
                            </button>
                        @endforeach
                    </div>

                    {{-- Form Content --}}
                    <form wire:submit.prevent="update">

                        {{-- Step 1: Account --}}
                        @if($currentStep === 1)
                            <div class="space-y-6 animate-fade-in">
                                <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-amber-500 pl-4">
                                    ข้อมูลบัญชีผู้ใช้</h2>

                                {{-- Photo Upload --}}
                                <div class="flex justify-center mb-8">
                                    <div class="relative group">
                                        <div
                                            class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-xl bg-slate-100 flex items-center justify-center">
                                            @if ($photo)
                                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                            @elseif($student->photo_path)
                                                <img src="{{ asset('images/students/' . $student->photo_path) }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <label
                                            class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity text-white font-bold text-xs">
                                            เปลี่ยนรูป
                                            <input type="file" wire:model.live="photo" class="hidden">
                                        </label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">Username <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" wire:model.blur="state.username" placeholder="ชื่อผู้ใช้ระบบ"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none @error('state.username') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                                        @error('state.username') <span
                                        class="text-xs text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">Password
                                            <span class="text-xs text-slate-400 font-normal">(เว้นว่างถ้าไม่ต้องการเปลี่ยน)</span>
                                        </label>
                                        <input type="password" wire:model.blur="state.password"
                                            placeholder="กรอกรหัสผ่านใหม่ (ถ้าต้องการเปลี่ยน)"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">รหัสนักเรียน <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" wire:model.blur="state.student_id" placeholder="เช่น 66101"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none @error('state.student_id') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                                        @error('state.student_id') <span
                                        class="text-xs text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">เลขบัตรประชาชน</label>
                                        <input type="text" wire:model.blur="state.id_card_number" placeholder="13 หลัก"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">เพศ</label>
                                        <select wire:model.blur="state.gender"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none appearance-none bg-white">
                                            <option value="">เลือกเพศ...</option>
                                            <option value="Male">ชาย</option>
                                            <option value="Female">หญิง</option>
                                        </select>
                                    </div>

                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">รุ่น (Batch)</label>
                                        <input type="text" wire:model.blur="state.batch"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">ปีงบประมาณ</label>
                                        <input type="text" wire:model.blur="state.fiscal_year"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Step 2: Personal --}}
                        @if($currentStep === 2)
                            <div class="space-y-6 animate-fade-in">
                                <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-amber-500 pl-4">ข้อมูลส่วนตัว
                                </h2>

                                <div class="bg-amber-50/50 p-6 rounded-2xl border border-amber-100">
                                    <h3 class="text-sm font-bold text-amber-600 uppercase tracking-wider mb-4">ชื่อภาษาไทย
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">คำนำหน้า</label>
                                            <input type="text" wire:model.blur="state.title_th" placeholder="นาย/นางสาว"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">ชื่อจริง <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model.blur="state.first_name_th"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none @error('state.first_name_th') border-red-500 @enderror">
                                            @error('state.first_name_th') <span class="text-xs text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">นามสกุล <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model.blur="state.last_name_th"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none @error('state.last_name_th') border-red-500 @enderror">
                                            @error('state.last_name_th') <span class="text-xs text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100">
                                    <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4">English Name
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">Title</label>
                                            <input type="text" wire:model.blur="state.title_en" placeholder="Mr./Ms."
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">First Name</label>
                                            <input type="text" wire:model.blur="state.first_name_en"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">Last Name</label>
                                            <input type="text" wire:model.blur="state.last_name_en"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">วันเกิด</label>
                                        <input type="date" wire:model.blur="state.birth_date"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">กรุ๊ปเลือด</label>
                                        <input type="text" wire:model.blur="state.blood_type"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">ศาสนา</label>
                                        <input type="text" wire:model.blur="state.religion"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">เชื้อชาติ</label>
                                        <input type="text" wire:model.blur="state.race"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">สัญชาติ</label>
                                        <input type="text" wire:model.blur="state.nationality"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">จังหวัดที่เกิด</label>
                                        <input type="text" wire:model.blur="state.birth_province"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Step 3: Address --}}
                        @if($currentStep === 3)
                            <div class="space-y-6 animate-fade-in">
                                <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-amber-500 pl-4">
                                    ที่อยู่และการติดต่อ</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">เบอร์โทรศัพท์</label>
                                        <input type="text" wire:model.blur="state.phone"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">อีเมล <span
                                                class="text-red-500">*</span></label>
                                        <input type="email" wire:model.blur="state.email"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none @error('state.email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                                        @error('state.email') <span
                                        class="text-xs text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-bold text-slate-700 ml-1">ที่อยู่ปัจจุบันโดยละเอียด</label>
                                    <textarea wire:model.blur="state.current_address" rows="3"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none resize-none"></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 text-left gap-6">
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">ตำบล/แขวง</label>
                                        <input type="text" wire:model.blur="state.subdistrict"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">อำเภอ/เขต</label>
                                        <input type="text" wire:model.blur="state.district"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">จังหวัด</label>
                                        <input type="text" wire:model.blur="state.province"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">รหัสไปรษณีย์</label>
                                        <input type="text" wire:model.blur="state.zip_code"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Step 4: Family --}}
                        @if($currentStep === 4)
                            <div class="space-y-6 animate-fade-in">
                                <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-amber-500 pl-4">ข้อมูลครอบครัว
                                </h2>

                                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200">
                                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">พ่อ</span>
                                        ข้อมูลบิดา
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">ชื่อ-นามสกุล</label>
                                            <input type="text" wire:model.blur="state.father_name"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">อาชีพ</label>
                                            <input type="text" wire:model.blur="state.father_occupation"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">รายได้ (บาท)</label>
                                            <input type="number" wire:model.blur="state.father_income"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">อายุ</label>
                                            <input type="number" wire:model.blur="state.father_age"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200">
                                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center text-xs">แม่</span>
                                        ข้อมูลมารดา
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">ชื่อ-นามสกุล</label>
                                            <input type="text" wire:model.blur="state.mother_name"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">อาชีพ</label>
                                            <input type="text" wire:model.blur="state.mother_occupation"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">รายได้ (บาท)</label>
                                            <input type="number" wire:model.blur="state.mother_income"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1 group">
                                            <label class="text-sm font-bold text-slate-700 ml-1">อายุ</label>
                                            <input type="number" wire:model.blur="state.mother_age"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Step 5: Education --}}
                        @if($currentStep === 5)
                            <div class="space-y-6 animate-fade-in">
                                <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-amber-500 pl-4">
                                    ประวัติการศึกษา</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">วันที่เข้าศึกษา</label>
                                        <input type="date" wire:model.blur="state.enrollment_date"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">วุฒิการศึกษา</label>
                                        <input type="text" wire:model.blur="state.degree_level"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group md:col-span-2">
                                        <label class="text-sm font-bold text-slate-700 ml-1">หลักสูตร</label>
                                        <select wire:model.blur="state.course_id"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none appearance-none bg-white">
                                            <option value="">เลือกหลักสูตร...</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->course_code }} -
                                                    {{ $course->course_name_th }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">เกรดเฉลี่ย (ถ้ามี)</label>
                                        <input type="text" wire:model.blur="state.gpa_y1_t1"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Step 6: Health --}}
                        @if($currentStep === 6)
                            <div class="space-y-6 animate-fade-in">
                                <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-amber-500 pl-4">ข้อมูลสุขภาพ
                                </h2>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">น้ำหนัก (กก.)</label>
                                        <input type="number" step="0.1" wire:model.blur="state.weight"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                    <div class="flex flex-col gap-1 group">
                                        <label class="text-sm font-bold text-slate-700 ml-1">ส่วนสูง (ซม.)</label>
                                        <input type="number" step="0.1" wire:model.blur="state.height"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700 ml-1">โรคประจำตัว</label>
                                    <textarea wire:model.blur="state.chronic_diseases" rows="2"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none resize-none"></textarea>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700 ml-1">ประวัติการแพ้ยา/อาหาร</label>
                                    <textarea wire:model.blur="state.allergies" rows="2"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all outline-none resize-none"></textarea>
                                </div>
                            </div>
                        @endif

                        {{-- Footer Actions --}}
                        <div class="mt-10 flex justify-between items-center pt-6 border-t border-slate-100">
                            @if($currentStep > 1)
                                <button type="button" wire:click="prevStep"
                                    class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors">
                                    ย้อนกลับ
                                </button>
                            @else
                                <a href="{{ route('students.show', $student->id) }}"
                                    class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    ยกเลิก
                                </a>
                            @endif

                            <div class="flex gap-4">
                                @if($currentStep < $totalSteps)
                                    <button type="button" wire:click="nextStep"
                                        class="px-8 py-3 rounded-xl bg-amber-600 text-white font-bold shadow-lg shadow-amber-500/30 hover:bg-amber-700 transition-all hover:scale-105 active:scale-95">
                                        ถัดไป
                                    </button>
                                @else
                                    <button type="submit"
                                        class="px-8 py-3 rounded-xl bg-green-600 text-white font-bold shadow-lg shadow-green-500/30 hover:bg-green-700 transition-all hover:scale-105 active:scale-95 flex items-center gap-2"
                                        wire:loading.attr="disabled"
                                        wire:target="update">
                                        <span wire:loading.remove wire:target="update" class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            บันทึกการแก้ไข
                                        </span>
                                        <span wire:loading wire:target="update" class="flex items-center gap-2">
                                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            กำลังบันทึก...
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Footer Branding --}}
            <div class="text-center mt-12 opacity-40">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">MEIMS • Version 4.0 Clean Code
                    Edition</p>
            </div>

        </div>

        {{-- Toast Notification --}}
        <div x-show="showToast" style="display: none" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed bottom-6 right-6 z-50 bg-slate-900/90 text-white px-6 py-4 rounded-xl shadow-2xl backdrop-blur-lg border border-slate-700 flex items-center gap-3">
            <div class="bg-red-500 rounded-full p-1">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </div>
            <span class="font-medium text-sm" x-text="toastMessage"></span>
        </div>

        {{-- SweetAlert2 Integration --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                @this.on('update-success', () => {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'แก้ไขข้อมูลนักเรียนเรียบร้อยแล้ว',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#F59E0B',
                        allowOutsideClick: false,
                        backdrop: `rgba(0,0,123,0.4)`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("students.show", $student->id) }}';
                        }
                    });
                });
            });
        </script>

    </div>
</div>
