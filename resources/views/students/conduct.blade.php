<x-layouts.app>
<div class="min-h-screen bg-background font-body flex">
    
    <!-- Sidebar Container -->
    <aside class="w-72 shrink-0 bg-surface border-r border-border flex flex-col fixed inset-y-0 left-0 z-40 hidden lg:flex">
        <x-sidebar />
    </aside>

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <header class="mb-10">
            <h1 class="text-2xl md:text-3xl font-bold text-text">บันทึกคะแนนความประพฤติ</h1>
            <p class="text-text-muted text-sm font-medium">จัดการคะแนนความประพฤติ ตัดคะแนน หรือเพิ่มคะแนน</p>
        </header>

        @if (session('message'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200">
                <ul class="list-disc list-inside text-sm pl-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Search & Select Section -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-surface rounded-2xl p-6 shadow-card border border-border">
                    <label class="block text-sm font-medium text-text-secondary text-sm mb-2">ค้นหานักเรียน</label>
                    <form action="{{ route('students.conduct') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ $search }}" placeholder="พิมพ์ชื่อ หรือ รหัสนักเรียน...แล้วกด Enter" class="w-full pl-10 pr-4 py-3 bg-surface-hover border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all">
                        <button type="submit" class="absolute left-3 top-3.5 text-text-disabled cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>

                    @if(strlen($search) > 1 && $searchResults->isNotEmpty())
                        <div class="mt-4 space-y-2">
                            @foreach($searchResults as $student)
                                <a href="{{ route('students.conduct', ['student_id' => $student->id, 'search' => $search]) }}" class="block w-full text-left p-3 rounded-xl hover:bg-info-light transition-colors flex items-center group {{ $selectedStudent && $selectedStudent->id == $student->id ? 'bg-info-light border-blue-200' : '' }}">
                                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-text-muted mr-3 overflow-hidden shrink-0">
                                        @if($student->photo_path)
                                            <img src="{{ asset('storage/'.$student->photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-text group-hover:text-blue-700">{{ $student->first_name_th }} {{ $student->last_name_th }}</p>
                                        <p class="text-xs text-text-muted text-sm font-medium">{{ $student->student_id }} | รุ่น {{ $student->batch }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @elseif(strlen($search) > 1)
                        <div class="mt-4 text-center text-text-disabled text-sm">
                            ไม่พบข้อมูลนักเรียน
                        </div>
                    @endif
                </div>

                @if($selectedStudent)
                <div class="bg-surface rounded-2xl p-6 shadow-card border border-border text-center relative overflow-hidden">
                     <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-orange-400 to-red-500"></div>
                     <div class="relative z-10 mt-8">
                         <div class="w-24 h-24 rounded-full bg-surface p-1 mx-auto shadow-lg mb-3">
                            <div class="w-full h-full rounded-full bg-surface-hover flex items-center justify-center overflow-hidden">
                                @if($selectedStudent->photo_path)
                                    <img src="{{ asset('storage/'.$selectedStudent->photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-text-disabled" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                @endif
                            </div>
                         </div>
                         <h2 class="text-xl font-bold text-text">{{ $selectedStudent->first_name_th }} {{ $selectedStudent->last_name_th }}</h2>
                         <p class="text-text-muted text-sm mb-6">{{ $selectedStudent->student_id }}</p>

                         <div class="bg-surface-hover rounded-2xl p-4 border border-border">
                             <p class="text-sm text-text-muted mb-1">คะแนนความประพฤติรวม</p>
                             <div class="text-4xl font-bold {{ $selectedStudent->total_conduct_score < 50 ? 'text-red-500' : ($selectedStudent->total_conduct_score < 80 ? 'text-orange-500' : 'text-green-500') }}">
                                 {{ $selectedStudent->total_conduct_score }}
                             </div>
                             <p class="text-xs text-text-disabled mt-1">เต็ม 100 คะแนน</p>
                         </div>
                     </div>
                </div>
                @endif
            </div>

            <!-- Management Section -->
            <div class="lg:col-span-2">
                @if($selectedStudent)
                    <!-- Form -->
                    <form action="{{ route('students.conduct.store') }}" method="POST" class="bg-surface rounded-2xl p-6 shadow-card border border-border mb-8" x-data="{ score_type: '{{ old('score_type', 'deduction') }}' }">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                        <input type="hidden" name="score_type" :value="score_type">
                        
                        <h3 class="font-bold text-lg text-text mb-4 pb-4 border-b border-slate-50">บันทึกรายการใหม่</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-text-secondary text-sm mb-2">ประเภท</label>
                                    <div class="flex space-x-2">
                                        <button type="button" @click="score_type = 'deduction'" :class="score_type === 'deduction' ? 'bg-error-light border-red-200 text-error font-bold' : 'bg-surface border-border text-text-muted hover:bg-slate-50'" class="flex-1 py-2 px-4 rounded-xl border transition-all text-sm cursor-pointer">
                                            ตัดคะแนน
                                        </button>
                                        <button type="button" @click="score_type = 'reward'" :class="score_type === 'reward' ? 'bg-green-50 border-green-200 text-green-600 font-bold' : 'bg-surface border-border text-text-muted hover:bg-slate-50'" class="flex-1 py-2 px-4 rounded-xl border transition-all text-sm cursor-pointer">
                                            เพิ่มคะแนน
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-text-secondary text-sm mb-2">จำนวนคะแนน</label>
                                    <input type="number" name="score_amount" min="1" value="{{ old('score_amount') }}" required class="w-full bg-surface-hover border border-border rounded-xl px-4 py-2 text-text-secondary focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition-all">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-text-secondary text-sm mb-2">สาเหตุ / รายละเอียด</label>
                                <textarea name="description" rows="3" required class="w-full bg-surface-hover border border-border rounded-xl px-4 py-3 text-text-secondary focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition-all" placeholder="ระบุสาเหตุที่ตัดหรือเพิ่มคะแนน...">{{ old('description') }}</textarea>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl shadow-md shadow-primary/20 transition-all flex items-center cursor-pointer">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- History -->
                    <div class="bg-surface rounded-3xl shadow-sm border border-border overflow-hidden">
                        <div class="p-6 border-b border-slate-50">
                            <h3 class="font-bold text-lg text-text">ประวัติคะแนนความประพฤติ</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-surface-hover/50">
                                    <tr class="text-text-muted text-xs font-semibold uppercase tracking-wider border-b border-border">
                                        <th class="px-6 py-4">วันที่</th>
                                        <th class="px-6 py-4">รายการ</th>
                                        <th class="px-6 py-4 text-center">คะแนน</th>
                                        <th class="px-6 py-4 text-right">ผู้บันทึก</th>
                                        <th class="px-6 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border/50">
                                    @forelse($selectedStudent->conductScores as $score)
                                        <tr class="group hover:bg-surface-hover transition-colors">
                                            <td class="px-6 py-4 text-sm text-text-muted text-sm font-medium">{{ $score->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-text-secondary text-sm">{{ $score->description }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $score->score < 0 ? 'bg-red-100 text-red-700' : 'bg-success-light text-success' }}">
                                                    {{ $score->score > 0 ? '+' : '' }}{{ $score->score }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-text-muted text-right">{{ $score->recorded_by }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <form action="{{ route('students.conduct.destroy', $score->id) }}" method="POST" class="inline-block" onsubmit="return confirm('ยืนยันการลบรายการนี้?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-text-disabled hover:text-error transition-colors cursor-pointer">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-text-disabled">
                                                ยังไม่มีประวัติการบันทึกคะแนน
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-text-disabled min-h-[400px]">
                        <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                        <p class="text-lg font-medium">กรุณาค้นหาและเลือกนักเรียนจากด้านซ้าย</p>
                        <p>เพื่อเริ่มบันทึกคะแนนความประพฤติ</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
</x-layouts.app>
