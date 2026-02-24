<x-layouts.app>
<div class="min-h-screen bg-background font-body flex">

    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-4 md:p-8 overflow-y-auto">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('students.index') }}"
                    class="p-2 bg-white rounded-xl shadow-sm border border-border text-text-muted hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-text">แก้ไขข้อมูลนักเรียน</h1>
                    <p class="text-text-muted text-sm font-medium mt-1">แก้ไขข้อมูลของ {{ $student->first_name_th }} {{ $student->last_name_th }}</p>
                </div>
            </div>
        </header>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <strong>พบข้อผิดพลาด:</strong>
                </div>
                <ul class="list-disc list-inside text-sm pl-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-surface rounded-2xl shadow-card border border-border overflow-hidden lg:max-w-4xl">
            <form action="{{ route('students.update', $student->id) }}" method="POST" class="divide-y divide-border">
                @csrf
                @method('PUT')
                
                <!-- Account Section -->
                <div class="p-6 md:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-text flex items-center">
                        <span class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                        ข้อมูลบัญชีผู้ใช้
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">ชื่อผู้ใช้งาน (Username) <span class="text-error">*</span></label>
                            <input type="text" name="username" value="{{ old('username', $student->username) }}" required
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">รหัสผ่าน (เว้นว่างไว้หากไม่ต้องการเปลี่ยน)</label>
                            <input type="password" name="password" 
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="p-6 md:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-text flex items-center">
                        <span class="w-8 h-8 bg-info/10 text-info rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </span>
                        ข้อมูลส่วนตัว
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">รหัสนักเรียน <span class="text-error">*</span></label>
                            <input type="text" name="student_id" value="{{ old('student_id', $student->student_id) }}" required
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">รุ่น <span class="text-error">*</span></label>
                            <input type="text" name="batch" value="{{ old('batch', $student->batch) }}" required
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">หลักสูตร</label>
                            <select name="course_id" class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm cursor-pointer">
                                <option value="">เลือกหลักสูตร</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $student->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name_th }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">ชื่อ (ไทย) <span class="text-error">*</span></label>
                            <input type="text" name="first_name_th" value="{{ old('first_name_th', $student->first_name_th) }}" required
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">นามสกุล (ไทย) <span class="text-error">*</span></label>
                            <input type="text" name="last_name_th" value="{{ old('last_name_th', $student->last_name_th) }}" required
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="p-6 md:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-text flex items-center">
                        <span class="w-8 h-8 bg-success/10 text-success rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                        ข้อมูลติดต่อ
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">อีเมล</label>
                            <input type="email" name="email" value="{{ old('email', $student->email) }}"
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">เบอร์โทรศัพท์</label>
                            <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">ที่อยู่ปัจจุบัน</label>
                        <textarea name="current_address" rows="3"
                            class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">{{ old('current_address', $student->current_address) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">ตำบล</label>
                            <input type="text" name="subdistrict" value="{{ old('subdistrict', $student->subdistrict) }}"
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">อำเภอ</label>
                            <input type="text" name="district" value="{{ old('district', $student->district) }}"
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">จังหวัด</label>
                            <input type="text" name="province" value="{{ old('province', $student->province) }}"
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">รหัสไปรษณีย์</label>
                            <input type="text" name="zip_code" value="{{ old('zip_code', $student->zip_code) }}"
                                class="w-full px-4 py-2.5 bg-surface-hover/50 border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-6 md:p-8 bg-surface-hover/30 flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('students.index') }}"
                        class="px-6 py-2.5 bg-white border border-border text-sm font-semibold text-text-secondary rounded-xl hover:bg-surface-hover transition-all text-center">
                        ยกเลิก
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold rounded-xl transition-all shadow-md shadow-primary/20 hover:-translate-y-0.5 active:scale-95">
                        บันทึกการเปลี่ยนแปลง
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
</x-layouts.app>
