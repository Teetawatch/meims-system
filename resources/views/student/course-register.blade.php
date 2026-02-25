<x-layouts.app>
<div class="min-h-screen bg-slate-50 relative font-['Plus_Jakarta_Sans','Anuphan',sans-serif] overflow-x-hidden"
    x-data="courseRegistrationData($el)"
    data-old-course="{{ old('course_id', '') }}">

    {{-- Premium Aurora Background Effects --}}
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-gradient-to-br from-blue-400/20 to-indigo-500/15 rounded-full blur-[120px] animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] bg-gradient-to-tr from-purple-400/20 to-pink-400/15 rounded-full blur-[120px] animate-blob animation-delay-4000"></div>
        <div class="absolute inset-0 bg-white/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 py-12 md:py-20">
        {{-- Header Section --}}
        <div class="text-center mb-16 animate-fade-in">
            <div class="inline-flex p-4 bg-white rounded-3xl shadow-2xl shadow-blue-500/10 mb-6 transform -rotate-3 hover:rotate-0 transition-all duration-500 border border-white">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight mb-4">
                ลงทะเบียน <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">หลักสูตรนักเรียน</span>
            </h1>
            <p class="text-slate-500 font-bold text-lg max-w-2xl mx-auto leading-relaxed">
                ระบบบริหารจัดการข้อมูลนักเรียน
            </p>
        </div>

        {{-- Main Form Card --}}
        <div class="bg-white/80 backdrop-blur-3xl rounded-[3rem] shadow-[0_32px_80px_rgba(0,0,0,0.06)] border border-white/50 overflow-hidden animate-slide-up">
            
            {{-- Progress Indicator --}}
            <div class="relative h-2 w-full bg-slate-100">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-600 transition-all duration-700 ease-in-out"
                    :style="`width: ${((currentStep) / totalSteps) * 100}%; box-shadow: 0 0 20px rgba(79, 70, 229, 0.4)`">
                </div>
            </div>

            <div class="p-8 md:p-14">
                {{-- Steps Navigation --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-14">
                    <template x-for="step in totalSteps" :key="step">
                        <button type="button" @click="goToStep(step)"
                            :class="{ 
                                'bg-slate-900 text-white shadow-xl scale-105 ring-4 ring-slate-900/10': currentStep === step,
                                'bg-white text-slate-600 border-slate-100 border hover:border-blue-200': currentStep !== step 
                            }"
                            class="flex items-center gap-3 p-4 rounded-2xl transition-all duration-300 font-black text-xs uppercase tracking-widest">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center text-sm"
                                  :class="currentStep === step ? 'bg-white/20' : 'bg-slate-100'">
                                <span x-text="step"></span>
                            </span>
                            <span x-text="['ข้อมูลทั่วไป', 'การทำงาน', 'การศึกษา', 'อื่นๆ'][step-1]" class="hidden md:inline"></span>
                        </button>
                    </template>
                </div>

                <form method="POST" action="{{ route('student.course-register.post') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Step 1: General Info --}}
                    <div x-show="currentStep === 1" class="space-y-10 animate-fade-in">
                        <div class="flex flex-col md:flex-row gap-12 items-center md:items-start">
                            {{-- Photo Upload --}}
                            <div class="relative group shrink-0">
                                <div class="w-48 h-48 rounded-[2.5rem] overflow-hidden border-8 border-white shadow-2xl bg-slate-100 flex items-center justify-center relative z-10 group-hover:scale-[1.02] transition-transform duration-500">
                                    <template x-if="previewPhoto">
                                        <img :src="previewPhoto" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!previewPhoto">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Upload Photo</span>
                                        </div>
                                    </template>
                                </div>
                                <label class="absolute inset-0 z-20 flex items-center justify-center bg-slate-900/60 rounded-[2.5rem] opacity-0 group-hover:opacity-100 cursor-pointer transition-all duration-500 backdrop-blur-sm">
                                    <span class="text-white font-black text-xs uppercase tracking-widest">Change Image</span>
                                    <input type="file" name="photo" class="hidden" @change="const file = $event.target.files[0]; if(file) previewPhoto = URL.createObjectURL(file);">
                                </label>
                                <div class="absolute -inset-4 bg-blue-500/10 rounded-[3.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>

                            <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-8">
                                {{-- Course Selection --}}
                                <div class="md:col-span-2 space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">หลักสูตรที่ต้องการลงทะเบียน</label>
                                    <select name="course_id" required x-model="selectedCourseId" @change="handleCourseChange($event)" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700 appearance-none shadow-sm">
                                        <option value="">เลือกหลักสูตร...</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" 
                                                    data-academic-year="{{ $course->academic_year }}" 
                                                    data-fiscal-year="{{ $course->fiscal_year_batch }}">
                                                {{ $course->course_name_th }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ประจำปีการศึกษา</label>
                                    <input type="text" name="academic_year" x-model="academicYear" placeholder="เช่น 2567" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">รุ่นปี งป.</label>
                                    <input type="text" name="fiscal_year_batch" x-model="fiscalYearBatch" placeholder="เช่น 67" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ชั้นยศ</label>
                                    <select name="rank" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700 appearance-none shadow-sm">
                                        <option value="">เลือกชั้นยศ...</option>
                                        <option value="น.อ.">น.อ.</option>
                                        <option value="น.ท.">น.ท.</option>
                                        <option value="น.ต.">น.ต.</option>
                                        <option value="ร.อ.">ร.อ.</option>
                                        <option value="ร.ท.">ร.ท.</option>
                                        <option value="ร.ต.">ร.ต.</option>
                                        <option value="พ.จ.อ.(พิเศษ)">พ.จ.อ.(พิเศษ)</option>
                                        <option value="พ.จ.อ.">พ.จ.อ.</option>
                                        <option value="พ.จ.ท.">พ.จ.ท.</option>
                                        <option value="พ.จ.ต.">พ.จ.ต.</option>
                                        <option value="จ.อ.">จ.อ.</option>
                                        <option value="จ.ท.">จ.ท.</option>
                                        <option value="จ.ต.">จ.ต.</option>
                                        <option value="พลฯ">พลฯ</option>
                                        <option value="นรจ.">นรจ.</option>
                                        <option value="นาย">นาย</option>
                                        <option value="นาง">นาง</option>
                                        <option value="นางสาว">นางสาว</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Username สำหรับเข้าระบบ</label>
                                    <input type="text" name="username" required placeholder="ตั้งชื่อผู้ใช้งาน" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Password สำหรับเข้าระบบ</label>
                                    <input type="password" name="password" required placeholder="ตั้งรหัสผ่าน" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                </div>

                                <div class="md:col-span-2 space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ชื่อ - นามสกุล</label>
                                    <input type="text" name="full_name" required placeholder="กรอกชื่อและนามสกุล" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">อายุ (ปี)</label>
                                <input type="number" name="age" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">สถานภาพ</label>
                                <select name="marital_status" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                    <option value="โสด">โสด</option>
                                    <option value="สมรส">สมรส</option>
                                    <option value="หย่า">หย่า</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Work & Family --}}
                    <div x-show="currentStep === 2" class="space-y-10 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ตำแหน่งปัจจุบัน</label>
                                <input type="text" name="position" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">สังกัด</label>
                                <input type="text" name="affiliation" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">วันที่บรรจุรับราชการ</label>
                                <input type="date" name="enlistment_date" x-model="enlistmentDate" @change="updateServiceAge()" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">อายุราชการ</label>
                                <input type="text" name="service_age" x-model="serviceAge" placeholder="จะคำนวณให้อัตโนมัติ" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                        </div>

                        {{-- Children Info --}}
                        <div class="pt-6 border-t border-slate-100">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                ข้อมูลครอบครัว
                            </h3>
                            <div class="mb-6">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ชื่อภรรยา/สามี (ถ้ามี)</label>
                                <input type="text" name="spouse_name" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl mt-2 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <template x-for="i in 4" :key="i">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2" x-text="`ข้อมูลบุตรคนที่ ${i}`"></label>
                                        <input type="text" :name="`children[${i-1}]`" placeholder="ระบุชื่อจริง-นามสกุล" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3: Education & Address --}}
                    <div x-show="currentStep === 3" class="space-y-10 animate-fade-in">
                        <div class="space-y-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">วุฒิการศึกษาสามัญก่อนรับราชการ</label>
                                <input type="text" name="education_before_service" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">วุฒิการศึกษาสูงสุด</label>
                                <input type="text" name="highest_education" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <template x-for="i in 3" :key="i">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2" x-text="`วุฒิการศึกษาทางทหาร ${i}`"></label>
                                        <input type="text" :name="`mil_edu[${i-1}]`" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100 grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="col-span-2 md:col-span-1 space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">บ้านเลขที่</label>
                                <input type="text" name="address_no" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">หมู่ที่</label>
                                <input type="text" name="village_no" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ซอย</label>
                                <input type="text" name="soi" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ถนน</label>
                                <input type="text" name="road" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ตำบล/แขวง</label>
                                <input type="text" name="subdistrict" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">อำเภอ/เขต</label>
                                <input type="text" name="district" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">จังหวัด</label>
                                <input type="text" name="province" list="province_list" placeholder="ค้นหาจังหวัด..." class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                <datalist id="province_list">
                                    <option value="กรุงเทพมหานคร">
                                    <option value="กระบี่">
                                    <option value="กาญจนบุรี">
                                    <option value="กาฬสินธุ์">
                                    <option value="กำแพงเพชร">
                                    <option value="ขอนแก่น">
                                    <option value="จันทบุรี">
                                    <option value="ฉะเชิงเทรา">
                                    <option value="ชลบุรี">
                                    <option value="ชัยนาท">
                                    <option value="ชัยภูมิ">
                                    <option value="ชุมพร">
                                    <option value="เชียงราย">
                                    <option value="เชียงใหม่">
                                    <option value="ตรัง">
                                    <option value="ตราด">
                                    <option value="ตาก">
                                    <option value="นครนายก">
                                    <option value="นครปฐม">
                                    <option value="นครพนม">
                                    <option value="นครราชสีมา">
                                    <option value="นครศรีธรรมราช">
                                    <option value="นครสวรรค์">
                                    <option value="นนทบุรี">
                                    <option value="นราธิวาส">
                                    <option value="น่าน">
                                    <option value="บึงกาฬ">
                                    <option value="บุรีรัมย์">
                                    <option value="ปทุมธานี">
                                    <option value="ประจวบคีรีขันธ์">
                                    <option value="ปราจีนบุรี">
                                    <option value="ปัตตานี">
                                    <option value="พระนครศรีอยุธยา">
                                    <option value="พะเยา">
                                    <option value="พังงา">
                                    <option value="พัทลุง">
                                    <option value="พิจิตร">
                                    <option value="พิษณุโลก">
                                    <option value="เพชรบุรี">
                                    <option value="เพชรบูรณ์">
                                    <option value="แพร่">
                                    <option value="ภูเก็ต">
                                    <option value="มหาสารคาม">
                                    <option value="มุกดาหาร">
                                    <option value="แม่ฮ่องสอน">
                                    <option value="ยโสธร">
                                    <option value="ยะลา">
                                    <option value="ร้อยเอ็ด">
                                    <option value="ระนอง">
                                    <option value="ระยอง">
                                    <option value="ราชบุรี">
                                    <option value="ลพบุรี">
                                    <option value="ลำปาง">
                                    <option value="ลำพูน">
                                    <option value="เลย">
                                    <option value="ศรีสะเกษ">
                                    <option value="สกลนคร">
                                    <option value="สงขลา">
                                    <option value="สตูล">
                                    <option value="สมุทรปราการ">
                                    <option value="สมุทรสงคราม">
                                    <option value="สมุทรสาคร">
                                    <option value="สระแก้ว">
                                    <option value="สระบุรี">
                                    <option value="สิงห์บุรี">
                                    <option value="สุโขทัย">
                                    <option value="สุพรรณบุรี">
                                    <option value="สุราษฎร์ธานี">
                                    <option value="สุรินทร์">
                                    <option value="หนองคาย">
                                    <option value="หนองบัวลำภู">
                                    <option value="อ่างทอง">
                                    <option value="อำนาจเจริญ">
                                    <option value="อุดรธานี">
                                    <option value="อุตรดิตถ์">
                                    <option value="อุทัยธานี">
                                    <option value="อุบลราชธานี">
                                </datalist>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">รหัสไปรษณีย์</label>
                                <input type="text" name="zip_code" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Step 4: Work & Motto --}}
                    <div x-show="currentStep === 4" class="space-y-10 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">สถานที่ทำงานปัจจุบัน</label>
                                <input type="text" name="workplace" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">เบอร์โทรศัพท์ที่ทำงาน</label>
                                <input type="text" name="workplace_phone" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">อีเมลติดต่อ</label>
                                <input type="email" name="email" required placeholder="example@email.com" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ตำแหน่งสำคัญในอดีต (ระบยุได้ 3 ตำแหน่ง)</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                                <template x-for="i in 3" :key="i">
                                    <input type="text" :name="`past_pos[${i-1}]`" :placeholder="`ลำดับที่ ${i}`" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm">
                                </template>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">ความสามารถพิเศษ</label>
                                <textarea name="special_skills" rows="3" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm resize-none"></textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">คติประจำตัว</label>
                                <textarea name="motto" rows="3" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-bold shadow-sm resize-none"></textarea>
                            </div>
                        </div>

                        {{-- Final Declaration --}}
                        <div class="p-6 bg-blue-50/50 rounded-3xl border border-blue-100/50">
                            <label class="flex items-start gap-4 cursor-pointer">
                                <input type="checkbox" required class="w-6 h-6 rounded-lg border-2 border-blue-200 text-blue-600 focus:ring-blue-500 mt-1">
                                <span class="text-xs font-bold text-slate-600 leading-relaxed">
                                    ข้าพเจ้าขอรับรองว่าข้อมูลการลงทะเบียนทั้งหมดเป็นความจริงทุกประการ หากตรวจสอบพบว่าไม่เป็นความจริง ข้าพเจ้ายอมรับการพิจารณาตามระเบียบของโรงเรียนพลาธิการ กรมพลาธิการทหารเรือต่อไป
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="mt-16 flex justify-between items-center pt-10 border-t border-slate-100">
                        <div x-show="currentStep > 1">
                            <button type="button" @click="currentStep--"
                                class="px-8 py-4 rounded-2xl bg-white border border-slate-200 text-slate-600 font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                                ย้อนกลับ
                            </button>
                        </div>
                        <div x-show="currentStep === 1"></div>

                        <div class="flex gap-4">
                            <div x-show="currentStep < totalSteps">
                                <button type="button" @click="nextStep()"
                                    class="px-10 py-4 rounded-2xl bg-slate-900 text-white font-black text-xs uppercase tracking-widest shadow-xl shadow-slate-900/20 hover:scale-[1.05] active:scale-[0.98] transition-all flex items-center gap-2">
                                    ไปต่อหน้าถัดไป
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </div>
                            <div x-show="currentStep === totalSteps">
                                <button type="submit"
                                    class="px-10 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black text-xs uppercase tracking-widest shadow-xl shadow-blue-600/25 hover:scale-[1.05] active:scale-[0.98] transition-all flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    ลงทะเบียนข้อมูลทั้งหมด
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Branding Footer --}}
        <div class="text-center mt-16 animate-fade-in opacity-40">
        </div>
    </div>

    {{-- SweetAlert2 & Alpine Script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function courseRegistrationData(el) {
            return {
                currentStep: 1,
                totalSteps: 4,
                previewPhoto: null,
                selectedCourseId: el.getAttribute('data-old-course') || '',
                academicYear: '',
                fiscalYearBatch: '',
                enlistmentDate: '',
                serviceAge: '',

                updateServiceAge() {
                    if (!this.enlistmentDate) {
                        this.serviceAge = '';
                        return;
                    }

                    const start = new Date(this.enlistmentDate);
                    const end = new Date();
                    
                    if (start > end) {
                        this.serviceAge = '0 ปี 0 เดือน';
                        return;
                    }

                    let years = end.getFullYear() - start.getFullYear();
                    let months = end.getMonth() - start.getMonth();

                    if (months < 0) {
                        years--;
                        months += 12;
                    }

                    let result = '';
                    if (years > 0) result += years + ' ปี ';
                    if (months > 0) result += months + ' เดือน';
                    if (years === 0 && months === 0) result = '0 ปี 0 เดือน';

                    this.serviceAge = result.trim();
                },

                handleCourseChange(event) {
                    const select = event.target;
                    const selectedOption = select.options[select.selectedIndex];
                    
                    if (selectedOption.value) {
                        this.academicYear = selectedOption.getAttribute('data-academic-year') || '';
                        this.fiscalYearBatch = selectedOption.getAttribute('data-fiscal-year') || '';
                    } else {
                        this.academicYear = '';
                        this.fiscalYearBatch = '';
                    }
                },

                goToStep(step) {
                    if (step < this.currentStep) {
                        this.currentStep = step;
                    } else if (step > this.currentStep) {
                        if (this.validateStep(this.currentStep)) {
                            this.currentStep = step;
                        }
                    }
                },

                nextStep() {
                    if (this.validateStep(this.currentStep)) {
                        this.currentStep++;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },

                validateStep(step) {
                    // Simple validation for required fields in the current visible area
                    const form = document.querySelector('form');
                    const inputs = form.querySelectorAll('input[required], select[required]');
                    let isValid = true;

                    inputs.forEach(input => {
                        // Only check if input is visible within current step
                        if (input.closest('div[x-show]') && input.offsetParent !== null) {
                            if (!input.value) {
                                isValid = false;
                                input.classList.add('ring-2', 'ring-red-500');
                            } else {
                                input.classList.remove('ring-2', 'ring-red-500');
                            }
                        }
                    });

                    if (!isValid) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'ข้อมูลไม่ครบถ้วน',
                            text: 'โปรดกรอกข้อมูลในช่องที่จำเป็นให้ครบถ้วนก่อนไปต่อครับ',
                            confirmButtonColor: '#0f172a'
                        });
                    }
                    return isValid;
                }
            }
        }
    </script>

    <style>
        @keyframes blob {
            0% { transform: scale(1); }
            33% { transform: scale(1.1) translate(20px, -20px); }
            66% { transform: scale(0.9) translate(-10px, 15px); }
            100% { transform: scale(1); }
        }
        .animate-blob {
            animation: blob 10s infinite alternate ease-in-out;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        [x-cloak] { display: none !important; }
    </style>
</div>
</x-layouts.app>
