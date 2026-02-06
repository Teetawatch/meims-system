<div class="min-h-screen bg-slate-50 font-['Outfit','Anuphan'] flex">
    
    <x-sidebar />

    <main class="flex-1 lg:ml-72 p-8 overflow-y-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-slate-800">บันทึกคะแนนความประพฤติ</h1>
            <p class="text-slate-500">จัดการคะแนนความประพฤติ ตัดคะแนน หรือเพิ่มคะแนน</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Search & Select Section -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <label class="block text-sm font-medium text-slate-700 mb-2">ค้นหานักเรียน</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="พิมพ์ชื่อ หรือ รหัสนักเรียน..." class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    @if(strlen($search) > 1 && $searchResults->isNotEmpty())
                        <div class="mt-4 space-y-2">
                            @foreach($searchResults as $student)
                                <button wire:click="selectStudent({{ $student->id }})" class="w-full text-left p-3 rounded-xl hover:bg-blue-50 transition-colors flex items-center group">
                                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 mr-3 overflow-hidden">
                                        @if($student->photo_path)
                                            <img src="{{ asset('storage/'.$student->photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 group-hover:text-blue-700">{{ $student->first_name_th }} {{ $student->last_name_th }}</p>
                                        <p class="text-xs text-slate-500">{{ $student->student_id }} | รุ่น {{ $student->batch }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @elseif(strlen($search) > 1)
                        <div class="mt-4 text-center text-slate-400 text-sm">
                            ไม่พบข้อมูลนักเรียน
                        </div>
                    @endif
                </div>

                @if($selectedStudent)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 text-center relative overflow-hidden">
                     <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-orange-400 to-red-500"></div>
                     <div class="relative z-10 mt-8">
                         <div class="w-24 h-24 rounded-full bg-white p-1 mx-auto shadow-lg mb-3">
                            <div class="w-full h-full rounded-full bg-slate-100 flex items-center justify-center overflow-hidden">
                                @if($selectedStudent->photo_path)
                                    <img src="{{ asset('storage/'.$selectedStudent->photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                @endif
                            </div>
                         </div>
                         <h2 class="text-xl font-bold text-slate-800">{{ $selectedStudent->first_name_th }} {{ $selectedStudent->last_name_th }}</h2>
                         <p class="text-slate-500 text-sm mb-6">{{ $selectedStudent->student_id }}</p>

                         <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                             <p class="text-sm text-slate-500 mb-1">คะแนนความประพฤติรวม</p>
                             <div class="text-4xl font-black {{ $selectedStudent->total_conduct_score < 50 ? 'text-red-500' : ($selectedStudent->total_conduct_score < 80 ? 'text-orange-500' : 'text-green-500') }}">
                                 {{ $selectedStudent->total_conduct_score }}
                             </div>
                             <p class="text-xs text-slate-400 mt-1">เต็ม 100 คะแนน</p>
                         </div>
                     </div>
                </div>
                @endif
            </div>

            <!-- Management Section -->
            <div class="lg:col-span-2">
                @if($selectedStudent)
                    <!-- Form -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mb-8">
                        <h3 class="font-bold text-lg text-slate-800 mb-4 pb-4 border-b border-slate-50">บันทึกรายการใหม่</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">ประเภท</label>
                                    <div class="flex space-x-2">
                                        <button wire:click="$set('score_type', 'deduction')" class="flex-1 py-2 px-4 rounded-xl border {{ $score_type === 'deduction' ? 'bg-red-50 border-red-200 text-red-600 font-bold' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50' }} transition-all text-sm">
                                            ตัดคะแนน
                                        </button>
                                        <button wire:click="$set('score_type', 'reward')" class="flex-1 py-2 px-4 rounded-xl border {{ $score_type === 'reward' ? 'bg-green-50 border-green-200 text-green-600 font-bold' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50' }} transition-all text-sm">
                                            เพิ่มคะแนน
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">จำนวนคะแนน</label>
                                    <input type="number" wire:model="score_amount" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                                    @error('score_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">สาเหตุ / รายละเอียด</label>
                                <textarea wire:model="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all" placeholder="ระบุสาเหตุที่ตัดหรือเพิ่มคะแนน..."></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end pt-2">
                                <button wire:click="saveScore" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- History -->
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-50">
                            <h3 class="font-bold text-lg text-slate-800">ประวัติคะแนนความประพฤติ</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50">
                                    <tr class="text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                                        <th class="px-6 py-4">วันที่</th>
                                        <th class="px-6 py-4">รายการ</th>
                                        <th class="px-6 py-4 text-center">คะแนน</th>
                                        <th class="px-6 py-4 text-right">ผู้บันทึก</th>
                                        <th class="px-6 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($selectedStudent->conductScores as $score)
                                        <tr class="group hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 text-sm text-slate-500">{{ $score->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-slate-700">{{ $score->description }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $score->score < 0 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                    {{ $score->score > 0 ? '+' : '' }}{{ $score->score }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-500 text-right">{{ $score->recorded_by }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <button wire:click="deleteScore({{ $score->id }})" wire:confirm="ยืนยันการลบรายการนี้?" class="text-slate-300 hover:text-red-500 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                                ยังไม่มีประวัติการบันทึกคะแนน
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-slate-300 min-h-[400px]">
                        <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                        <p class="text-lg font-medium">กรุณาค้นหาและเลือกนักเรียนจากด้านซ้าย</p>
                        <p>เพื่อเริ่มบันทึกคะแนนความประพฤติ</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
