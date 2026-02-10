<div class="min-h-screen bg-slate-50 font-['Outfit','Anuphan'] flex">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('students.index') }}"
                    class="p-2 bg-white rounded-xl shadow-sm border border-slate-200 text-slate-500 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">ข้อมูลนักเรียน</h1>
                    <p class="text-slate-500 text-sm">รายละเอียดข้อมูลของ {{ $student->first_name_th }}
                        {{ $student->last_name_th }}</p>
                </div>
            </div>

            <a href="{{ route('students.edit', $student->id) }}"
                class="inline-flex items-center px-4 py-2 bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 hover:text-blue-600 font-medium rounded-xl transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                    </path>
                </svg>
                แก้ไขข้อมูล
            </a>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Profile Card -->
            <div class="space-y-6">
                <div
                    class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                    <div class="relative z-10">
                        @if($student->photo_path)
                            <img src="{{ asset('storage/' . $student->photo_path) }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md mx-auto mb-4">
                        @else
                            <div
                                class="w-32 h-32 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 mx-auto mb-4 border-4 border-white shadow-md">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                        <h2 class="text-xl font-bold text-slate-800">
                            {{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</h2>
                        <p class="text-slate-500 text-sm mb-4">{{ $student->title_en }} {{ $student->first_name_en }}
                            {{ $student->last_name_en }}</p>

                        <div class="flex justify-center space-x-2 mb-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">รุ่น
                                {{ $student->batch }}</span>
                            <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-semibold">สถานะ:
                                ปกติ</span>
                        </div>

                        <div class="border-t border-slate-50 pt-4 grid grid-cols-2 gap-4 text-left p-2">
                            <div>
                                <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">รหัสนักเรียน
                                </p>
                                <p class="text-slate-700 font-medium">{{ $student->student_id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">วันเกิด</p>
                                <p class="text-slate-700 font-medium">
                                    {{ $student->birth_date ? $student->birth_date->format('d/m/Y') : '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">เข้าศึกษาเมื่อ
                                </p>
                                <p class="text-slate-700 font-medium">
                                    {{ $student->enrollment_date ? $student->enrollment_date->format('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        ช่องทางติดต่อ
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <span class="text-slate-400 text-sm w-24 flex-shrink-0">เบอร์โทร</span>
                            <span class="text-slate-700 font-medium">{{ $student->phone }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-slate-400 text-sm w-24 flex-shrink-0">อีเมล</span>
                            <span class="text-slate-700 font-medium break-all">{{ $student->email }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-slate-400 text-sm w-24 flex-shrink-0">ที่อยู่</span>
                            <span class="text-slate-700 font-medium text-sm leading-relaxed">
                                {{ $student->current_address }}<br>
                                ต.{{ $student->subdistrict }} อ.{{ $student->district }}<br>
                                จ.{{ $student->province }} {{ $student->zip_code }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Info -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800 mb-6 border-b border-slate-50 pb-4">ข้อมูลส่วนตัว</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">เลขบัตรประชาชน
                            </p>
                            <p class="text-slate-700">{{ $student->id_card_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">สัญชาติ /
                                เชื้อชาติ</p>
                            <p class="text-slate-700">{{ $student->nationality }} / {{ $student->race }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">ศาสนา</p>
                            <p class="text-slate-700">{{ $student->religion }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">จังหวัดที่เกิด
                            </p>
                            <p class="text-slate-700">{{ $student->birth_province }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">ส่วนสูง /
                                น้ำหนัก</p>
                            <p class="text-slate-700">{{ $student->height }} ซม. / {{ $student->weight }} กก.</p>
                        </div>
                    </div>
                </div>

                <!-- Family Info -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800 mb-6 border-b border-slate-50 pb-4">ข้อมูลครอบครัว</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">ชื่อบิดา</p>
                            <p class="text-slate-700 font-medium">{{ $student->father_name }}
                                ({{ $student->father_age }} ปี)</p>
                            <p class="text-slate-500 text-sm">อาชีพ: {{ $student->father_occupation }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">ชื่อมารดา</p>
                            <p class="text-slate-700 font-medium">{{ $student->mother_name }}
                                ({{ $student->mother_age }} ปี)</p>
                            <p class="text-slate-500 text-sm">อาชีพ: {{ $student->mother_occupation }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">
                                สถานภาพสมรสผู้ปกครอง</p>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                {{ $student->parents_marital_status }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">
                                รายได้รวมครอบครัว</p>
                            <p class="text-slate-700 font-medium">{{ number_format($student->total_family_income, 0) }}
                                บาท/เดือน</p>
                        </div>
                    </div>
                </div>

                <!-- Education Info -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800 mb-6 border-b border-slate-50 pb-4">ข้อมูลการศึกษา</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">ระดับการศึกษา
                            </p>
                            <p class="text-slate-700">{{ $student->degree_level }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">หลักสูตร</p>
                            <p class="text-slate-700">{{ $student->course_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">เกรดเฉลี่ย (ปี
                                1 เทอม 1)</p>
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-blue-600 mr-2">{{ $student->gpa_y1_t1 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>