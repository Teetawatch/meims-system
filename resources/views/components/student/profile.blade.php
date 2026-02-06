<div class="min-h-screen flex bg-slate-50">
    <x-student-sidebar />
    <main class="flex-1 lg:ml-72 p-8 md:p-12 overflow-y-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">ข้อมูลส่วนตัว</h1>
            <p class="text-slate-500 font-medium mt-1">รายละเอียดข้อมูลส่วนตัวและหลักสูตร</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Photo & Basic -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-blue-600 to-indigo-700"></div>
                    
                    <div class="relative z-10">
                        <div class="relative inline-block group mb-6">
                            <div class="w-32 h-32 md:w-40 md:h-40 rounded-[2.5rem] overflow-hidden ring-4 ring-white shadow-2xl mx-auto bg-slate-100">
                                @if($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($student->photo_path)
                                    <img src="{{ asset('storage/'.$student->photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-blue-600 flex items-center justify-center text-white text-4xl font-black">
                                        {{ mb_substr($student->first_name_th, 0, 1) }}
                                    </div>
                                @endif
                                
                                <label class="absolute inset-0 flex items-center justify-center bg-black/40 text-white opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-[2.5rem]">
                                    <input type="file" wire:model="photo" class="hidden">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                </label>
                            </div>
                            @if($photo)
                                <button wire:click="updatePhoto" class="absolute -bottom-2 -right-2 bg-green-500 text-white p-2 rounded-xl shadow-lg hover:bg-green-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-black text-slate-800 capitalize">{{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</h3>
                        <p class="text-blue-600 font-bold mt-1">{{ $student->student_id }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                    <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">การติดต่อ</h4>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">อีเมล</p>
                                <p class="text-sm font-medium text-slate-700">{{ $student->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">เบอร์โทรศัพท์</p>
                                <p class="text-sm font-medium text-slate-700">{{ $student->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Details -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-8 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xl font-black text-slate-800">ข้อมูลรายละเอียด</h3>
                        <span class="px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">สถานะ: ปกติ</span>
                    </div>
                    
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">เลขประจำตัวประชาชน</p>
                            <p class="text-md font-bold text-slate-800">{{ $student->id_card_number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">วันเกิด</p>
                            <p class="text-md font-bold text-slate-800">{{ $student->birth_date->format('d/m/Y') }} ({{ $student->birth_date->age }} ปี)</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">สัญชาติ/ศาสนา</p>
                            <p class="text-md font-bold text-slate-800">{{ $student->nationality ?? '-' }} / {{ $student->religion ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">น้ำหนัก/ส่วนสูง</p>
                            <p class="text-md font-bold text-slate-800">{{ $student->weight ?? '-' }} กก. / {{ $student->height ?? '-' }} ซม.</p>
                        </div>
                        <div class="md:col-span-2">
                             <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">ที่อยู่ปัจจุบัน</p>
                             <p class="text-md font-bold text-slate-800 leading-relaxed">
                                 {{ $student->current_address }} ต.{{ $student->subdistrict }} อ.{{ $student->district }} จ.{{ $student->province }} {{ $student->zip_code }}
                             </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-8 bg-slate-50/50 border-b border-slate-100">
                        <h3 class="text-xl font-black text-slate-800">ข้อมูลหลักสูตร</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">หลักสูตรที่ศึกษา</p>
                            <p class="text-md font-bold text-slate-800">{{ $student->course->course_name_th ?? $student->course_name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">ปีที่เข้าเรียน / รุ่น</p>
                            <p class="text-md font-bold text-slate-800">{{ $student->fiscal_year }} / รุ่นที่ {{ $student->batch }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">วันทึ่ลงทะเบียน</p>
                            <p class="text-md font-bold text-slate-800">{{ $student->enrollment_date?->format('d/m/Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">ระดับการศึกษา</p>
                            <p class="text-md font-bold text-slate-800">{{ $student->degree_level ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
