<x-layouts.app>
<div class="min-h-screen bg-surface-hover relative font-['Outfit','Anuphan',sans-serif] overflow-hidden"
    x-data="studentRegistrationData()">

    {{-- Background Effects --}}
    <div class="fixed inset-0 w-full h-full pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-400/20 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-purple-400/20 rounded-full blur-[100px] animate-pulse animation-delay-2000"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10"></div>
    </div>

    {{-- Content Wrapper --}}
    <div class="relative z-10 max-w-5xl mx-auto px-4 py-8 md:py-12 pb-32">

        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="inline-flex p-3 bg-surface rounded-2xl shadow-lg shadow-blue-500/10 mb-4 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-text tracking-tight mb-2">
                ลงทะเบียนนักเรียนใหม่
            </h1>
            <p class="text-text-muted font-medium text-sm md:text-base">
                ระบบบริหารจัดการข้อมูลสารสนเทศด้านการศึกษา (MEIMS)
            </p>
        </div>

        {{-- Main Validations Alert --}}
        @if($errors->any())
            <div class="mb-8 p-4 bg-error-light border border-red-100 rounded-2xl flex items-start gap-4 animate-fade-in-down">
                <div class="bg-red-100 text-error p-2 rounded-xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-red-700">พบข้อผิดพลาด</h4>
                    <ul class="mt-1 list-disc list-inside text-sm text-error">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Success Alert --}}
        @if(session('success'))
            <div x-init="
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#3B82F6',
                    allowOutsideClick: false,
                    backdrop: `rgba(0,0,123,0.4)`
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/';
                    }
                });
            "></div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-white/50 overflow-hidden">

            {{-- Progress Bar --}}
            <div class="h-1.5 w-full bg-surface-hover">
                <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-600 transition-all duration-500 ease-out"
                    :style="`width: ${((currentStep) / totalSteps) * 100}%`">
                </div>
            </div>

            <div class="p-6 md:p-10">
                {{-- Steps Navigation (Bento Grid Style) --}}
                <div class="grid grid-cols-3 md:grid-cols-6 gap-2 md:gap-4 mb-10">
                    <template x-for="step in totalSteps" :key="step">
                        <button type="button" @click="goToStep(step)"
                            :class="{ 
                                'bg-primary border-blue-600 text-white shadow-lg scale-105': currentStep === step,
                                'bg-surface border-blue-200 text-blue-600': currentStep !== step && currentStep > step,
                                'bg-surface-hover border-transparent text-text-disabled hover:bg-slate-100': currentStep < step 
                            }"
                            class="flex flex-col items-center justify-center p-3 rounded-2xl border transition-all duration-300">
                            
                            {{-- Account Icon --}}
                            <svg x-show="step === 1" class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{-- Personal Icon --}}
                            <svg x-show="step === 2" class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            {{-- Address Icon --}}
                            <svg x-show="step === 3" class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            {{-- Family Icon --}}
                            <svg x-show="step === 4" class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{-- Education Icon --}}
                            <svg x-show="step === 5" class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                            {{-- Health Icon --}}
                            <svg x-show="step === 6" class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-7.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>

                            <span class="text-[10px] font-bold uppercase tracking-wider" x-text="['บัญชี', 'บุคคล', 'ที่อยู่', 'ครอบครัว', 'การศึกษา', 'สุขภาพ'][step-1]"></span>
                        </button>
                    </template>
                </div>

                {{-- Form Content --}}
                <form method="POST" action="{{ route('student.register.post') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Step 1: Account --}}
                    <div x-show="currentStep === 1" id="step1" class="space-y-6 animate-fade-in">
                        <h2 class="text-2xl font-bold text-text border-l-4 border-blue-500 pl-4">ข้อมูลบัญชีผู้ใช้</h2>

                        {{-- Photo Upload --}}
                        <div class="flex justify-center mb-8">
                            <div class="relative group">
                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-xl bg-surface-hover flex items-center justify-center">
                                    <template x-if="previewPhoto">
                                        <img :src="previewPhoto" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!previewPhoto">
                                        <svg class="w-12 h-12 text-text-disabled" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </template>
                                </div>
                                <label class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity text-white font-bold text-xs">
                                    เปลี่ยนรูป
                                    <input type="file" name="photo" class="hidden" @change="const file = $event.target.files[0]; if(file) previewPhoto = URL.createObjectURL(file);">
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">Username <span class="text-error">*</span></label>
                                <input type="text" name="username" value="{{ old('username') }}" placeholder="ตั้งชื่อผู้ใช้ระบบ" required
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>

                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">Password <span class="text-error">*</span></label>
                                <input type="password" name="password" placeholder="รหัสผ่านอย่างน้อย 6 ตัวอักษร" required
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>

                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">รหัสนักเรียน <span class="text-error">*</span></label>
                                <input type="text" name="student_id" value="{{ old('student_id') }}" placeholder="เช่น 66101" required
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>

                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">เลขบัตรประชาชน <span class="text-error">*</span></label>
                                <input type="text" name="id_card_number" value="{{ old('id_card_number') }}" placeholder="13 หลัก" required
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>

                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">เพศ <span class="text-error">*</span></label>
                                <select name="gender" required
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none appearance-none bg-surface">
                                    <option value="">เลือกเพศ...</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>ชาย</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>หญิง</option>
                                </select>
                            </div>

                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">รุ่น (Batch)</label>
                                <input type="text" name="batch" value="{{ old('batch') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>

                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">ปีงบประมาณ</label>
                                <input type="text" name="fiscal_year" value="{{ old('fiscal_year') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Personal --}}
                    <div x-show="currentStep === 2" id="step2" class="space-y-6 animate-fade-in" style="display:none;">
                        <h2 class="text-2xl font-bold text-text border-l-4 border-blue-500 pl-4">ข้อมูลส่วนตัว
                        </h2>

                        <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                            <h3 class="text-sm font-bold text-primary uppercase tracking-wider mb-4">ชื่อภาษาไทย</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">คำนำหน้า</label>
                                    <input type="text" name="title_th" value="{{ old('title_th') }}" placeholder="นาย/นางสาว"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">ชื่อจริง <span class="text-error">*</span></label>
                                    <input type="text" name="first_name_th" value="{{ old('first_name_th') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">นามสกุล <span class="text-error">*</span></label>
                                    <input type="text" name="last_name_th" value="{{ old('last_name_th') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100">
                            <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4">English Name</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">Title</label>
                                    <input type="text" name="title_en" value="{{ old('title_en') }}" placeholder="Mr./Ms."
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">First Name</label>
                                    <input type="text" name="first_name_en" value="{{ old('first_name_en') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">Last Name</label>
                                    <input type="text" name="last_name_en" value="{{ old('last_name_en') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">วันเกิด</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">กรุ๊ปเลือด</label>
                                <input type="text" name="blood_type" value="{{ old('blood_type') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">ศาสนา</label>
                                <input type="text" name="religion" value="{{ old('religion') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">เชื้อชาติ</label>
                                <input type="text" name="race" value="{{ old('race') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">สัญชาติ</label>
                                <input type="text" name="nationality" value="{{ old('nationality') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Step 3: Address --}}
                    <div x-show="currentStep === 3" id="step3" class="space-y-6 animate-fade-in" style="display:none;">
                        <h2 class="text-2xl font-bold text-text border-l-4 border-blue-500 pl-4">ที่อยู่และการติดต่อ</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">เบอร์โทรศัพท์ <span class="text-error">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">อีเมล <span class="text-error">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-text-secondary ml-1">ที่อยู่ปัจจุบันโดยละเอียด</label>
                            <textarea name="current_address" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none resize-none">{{ old('current_address') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 text-left gap-6">
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">ตำบล/แขวง</label>
                                <input type="text" name="subdistrict" value="{{ old('subdistrict') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">อำเภอ/เขต</label>
                                <input type="text" name="district" value="{{ old('district') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">จังหวัด</label>
                                <input type="text" name="province" value="{{ old('province') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">รหัสไปรษณีย์</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Step 4: Family --}}
                    <div x-show="currentStep === 4" id="step4" class="space-y-6 animate-fade-in" style="display:none;">
                        <h2 class="text-2xl font-bold text-text border-l-4 border-blue-500 pl-4">ข้อมูลครอบครัว</h2>

                        <div class="p-6 bg-surface-hover rounded-2xl border border-border">
                            <h3 class="font-bold text-text mb-4 flex items-center gap-2">
                                <span class="w-8 h-8 rounded-lg bg-blue-100 text-primary flex items-center justify-center text-xs">พ่อ</span>
                                ข้อมูลบิดา
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">ชื่อ-นามสกุล</label>
                                    <input type="text" name="father_name" value="{{ old('father_name') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">อาชีพ</label>
                                    <input type="text" name="father_occupation" value="{{ old('father_occupation') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">รายได้ (บาท)</label>
                                    <input type="number" name="father_income" value="{{ old('father_income') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">อายุ</label>
                                    <input type="number" name="father_age" value="{{ old('father_age') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-surface-hover rounded-2xl border border-border">
                            <h3 class="font-bold text-text mb-4 flex items-center gap-2">
                                <span class="w-8 h-8 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center text-xs">แม่</span>
                                ข้อมูลมารดา
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">ชื่อ-นามสกุล</label>
                                    <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">อาชีพ</label>
                                    <input type="text" name="mother_occupation" value="{{ old('mother_occupation') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">รายได้ (บาท)</label>
                                    <input type="number" name="mother_income" value="{{ old('mother_income') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-1 group">
                                    <label class="text-sm font-bold text-text-secondary ml-1">อายุ</label>
                                    <input type="number" name="mother_age" value="{{ old('mother_age') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 5: Education --}}
                    <div x-show="currentStep === 5" id="step5" class="space-y-6 animate-fade-in" style="display:none;">
                        <h2 class="text-2xl font-bold text-text border-l-4 border-blue-500 pl-4">ประวัติการศึกษา</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">วันที่เข้าศึกษา</label>
                                <input type="date" name="enrollment_date" value="{{ old('enrollment_date') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">วุฒิการศึกษา</label>
                                <input type="text" name="degree_level" value="{{ old('degree_level') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group md:col-span-2">
                                <label class="text-sm font-bold text-text-secondary ml-1">หลักสูตร <span class="text-error">*</span></label>
                                <select name="course_id" required
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none appearance-none bg-surface">
                                    <option value="">เลือกหลักสูตร...</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->course_code }} - {{ $course->course_name_th }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">เกรดเฉลี่ย (ถ้ามี)</label>
                                <input type="text" name="gpa_y1_t1" value="{{ old('gpa_y1_t1') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Step 6: Health --}}
                    <div x-show="currentStep === 6" id="step6" class="space-y-6 animate-fade-in" style="display:none;">
                        <h2 class="text-2xl font-bold text-text border-l-4 border-blue-500 pl-4">ข้อมูลสุขภาพ</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">น้ำหนัก (กก.)</label>
                                <input type="number" step="0.1" name="weight" value="{{ old('weight') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-1 group">
                                <label class="text-sm font-bold text-text-secondary ml-1">ส่วนสูง (ซม.)</label>
                                <input type="number" step="0.1" name="height" value="{{ old('height') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-text-secondary ml-1">โรคประจำตัว</label>
                            <textarea name="chronic_diseases" rows="2"
                                class="w-full px-4 py-3 rounded-xl border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none resize-none">{{ old('chronic_diseases') }}</textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-text-secondary ml-1">ประวัติการแพ้ยา/อาหาร</label>
                            <textarea name="allergies" rows="2"
                                class="w-full px-4 py-3 rounded-xl border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none resize-none">{{ old('allergies') }}</textarea>
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="mt-10 flex justify-between items-center pt-6 border-t border-border">
                        <div x-show="currentStep > 1">
                            <button type="button" @click="currentStep--"
                                class="px-6 py-3 rounded-xl border border-border text-text-secondary font-bold hover:bg-surface-hover transition-colors">
                                ย้อนกลับ
                            </button>
                        </div>
                        <div x-show="currentStep <= 1"></div> {{-- Spacer --}}

                        <div class="flex gap-4">
                            <div x-show="currentStep < totalSteps">
                                <button type="button" @click="nextStep()"
                                    class="px-8 py-3 rounded-xl bg-primary text-white font-bold shadow-md shadow-primary/20 hover:bg-primary-dark transition-all hover:scale-105 active:scale-95">
                                    ถัดไป
                                </button>
                            </div>
                            <div x-show="currentStep === totalSteps">
                                <button type="submit" @click="submitForm($event)"
                                    class="px-8 py-3 rounded-xl bg-green-600 text-white font-bold shadow-lg shadow-green-500/30 hover:bg-green-700 transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    ยืนยันข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Footer Branding --}}
        <div class="text-center mt-12 opacity-40">
            <p class="text-xs font-bold text-text-muted uppercase tracking-widest">MEIMS • Version 4.0 Clean Code Edition</p>
        </div>

    </div>

    {{-- SweetAlert2 Integration --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function studentRegistrationData() {
            return {
                currentStep: 1, 
                totalSteps: 6, 
                previewPhoto: null,
                
                goToStep(step) {
                    if (step < this.currentStep) {
                        this.currentStep = step;
                    } else if (step > this.currentStep) {
                        let canProceed = true;
                        for(let i = this.currentStep; i < step; i++) {
                            if (!this.validateStep(i)) {
                                this.currentStep = i; // Switch to failing step
                                canProceed = false;
                                break;
                            }
                        }
                        if (canProceed) {
                            this.currentStep = step;
                        }
                    }
                },

                nextStep() {
                    if (this.validateStep(this.currentStep)) {
                        this.currentStep++;
                    }
                },
                
                validateStep(step) {
                    const stepEl = document.getElementById('step' + step);
                    if (!stepEl) return true;
                    
                    const requiredFields = stepEl.querySelectorAll('input[required], select[required], textarea[required]');
                    let isValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            
                            // Visual error cue
                            field.classList.remove('focus:border-primary', 'focus:ring-primary/20', 'border-border');
                            field.classList.add('border-error', 'bg-red-50/50', 'ring-1', 'ring-error');
                            
                            // Remove error styling on user input
                            const removeError = function() {
                                if (this.value.trim()) {
                                    this.classList.remove('border-error', 'bg-red-50/50', 'ring-1', 'ring-error');
                                    this.classList.add('focus:border-primary', 'focus:ring-primary/20', 'border-border');
                                    this.removeEventListener('input', removeError);
                                    this.removeEventListener('change', removeError);
                                }
                            };
                            field.addEventListener('input', removeError);
                            field.addEventListener('change', removeError);
                        }
                    });
                    
                    if (!isValid) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'ข้อมูลไม่ครบถ้วน',
                            text: 'กรุณากรอกข้อมูลในช่องที่มีเครื่องหมายดอกจัน (*) ให้ครบถ้วนเพื่อดำเนินการต่อ',
                            confirmButtonColor: '#3b82f6',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                    
                    return isValid;
                },
                
                submitForm(e) {
                    // Final validation over all tabs before submit guarantees browser won't silently fail
                    for(let i = 1; i <= this.totalSteps; i++) {
                        if (!this.validateStep(i)) {
                            this.currentStep = i;
                            e.preventDefault();
                            return;
                        }
                    }
                }
            }
        }
    </script>
</div>
</x-layouts.app>
