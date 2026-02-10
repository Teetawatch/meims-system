<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::guard('student')->check()) {
        return redirect()->route('student.dashboard');
    }
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('student.login');
});

Route::get('/student/register', \App\Livewire\StudentRegistration::class)->name('student.register');

Route::get('/login', \App\Livewire\Auth\Login::class)->name('login')->middleware('guest');
Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard')->middleware('auth');
Route::get('/students', \App\Livewire\StudentManagement::class)->name('students.index')->middleware('auth');
Route::get('/students/conduct', \App\Livewire\StudentConduct::class)->name('students.conduct')->middleware('auth');
Route::get('/students/{student}/edit', \App\Livewire\StudentEdit::class)->name('students.edit')->middleware('auth');
Route::get('/students/{student}', \App\Livewire\StudentDetail::class)->name('students.show')->middleware('auth');
Route::get('/surveys', \App\Livewire\SurveyManagement::class)->name('surveys.index')->middleware('auth');
Route::get('/subjects', \App\Livewire\SubjectManagement::class)->name('subjects.index')->middleware('auth');
Route::get('/timetables', \App\Livewire\TimetableManagement::class)->name('timetables.index')->middleware('auth');
Route::get('/documents', \App\Livewire\DocumentManagement::class)->name('documents.index')->middleware('auth');
Route::get('/grades', \App\Livewire\GradeManagement::class)->name('grades.index')->middleware('auth');
Route::get('/transcripts', \App\Livewire\TranscriptManagement::class)->name('transcripts.index')->middleware('auth');
Route::get('/transcripts/download', [\App\Http\Controllers\TranscriptController::class, 'download'])->name('transcripts.download')->middleware('auth');
Route::get('/teachers', \App\Livewire\TeacherManagement::class)->name('teachers.index')->middleware('auth');
Route::get('/reports/evaluations', \App\Livewire\EvaluationReport::class)->name('reports.evaluations')->middleware('auth');
Route::get('/guardians', \App\Livewire\GuardianManagement::class)->name('guardians.index')->middleware('auth');
Route::get('/announcements', \App\Livewire\AnnouncementManagement::class)->name('announcements.index')->middleware('auth');

// Student Portal
Route::get('/student/login', \App\Livewire\Student\Login::class)->name('student.login');
Route::get('/student/logout', function () {
    Auth::guard('student')->logout();
    return redirect()->route('student.login');
})->name('student.logout');

Route::middleware(['auth:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Student\Dashboard::class)->name('dashboard');
    Route::get('/profile', \App\Livewire\Student\Profile::class)->name('profile');
    Route::get('/timetable', \App\Livewire\Student\Timetable::class)->name('timetable');
    Route::get('/grades', \App\Livewire\Student\Grades::class)->name('grades');
    Route::get('/conduct', \App\Livewire\Student\Conduct::class)->name('conduct');
    Route::get('/surveys', \App\Livewire\Student\Surveys::class)->name('surveys');
    Route::get('/surveys/{survey}', \App\Livewire\Student\DoSurvey::class)->name('surveys.do'); // Add this route
    Route::get('/documents', \App\Livewire\Student\Documents::class)->name('documents');
    Route::get('/evaluation', \App\Livewire\Student\Evaluation::class)->name('evaluation');
    Route::get('/evaluation/teacher/{subjectId}', \App\Livewire\Student\TeacherEvaluation::class)->name('teacher-evaluation');
    Route::get('/evaluation/peer/{studentId}', \App\Livewire\Student\PeerEvaluation::class)->name('peer-evaluation');
    Route::get('/change-password', \App\Livewire\Student\ChangePassword::class)->name('change-password');
});

// Guardian Portal
Route::get('/guardian/login', \App\Livewire\Guardian\Login::class)->name('guardian.login');
Route::get('/guardian/logout', function () {
    Auth::guard('guardian')->logout();
    return redirect()->route('guardian.login');
})->name('guardian.logout');

Route::middleware(['auth:guardian'])->prefix('guardian')->name('guardian.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Guardian\Dashboard::class)->name('dashboard');
    Route::get('/student/{student}', \App\Livewire\Guardian\StudentInfo::class)->name('student');
});

Route::get('/reports/students', \App\Livewire\StudentReport::class)->name('reports.students')->middleware('auth');
Route::get('/reports/students/pdf', [\App\Http\Controllers\ReportController::class, 'exportStudentPdf'])->name('reports.students.pdf')->middleware('auth');
Route::get('/courses', \App\Livewire\CourseManagement::class)->name('courses.index')->middleware('auth');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
