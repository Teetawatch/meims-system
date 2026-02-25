<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Student\Auth\LoginController as StudentLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
|
*/

// Temporary Setup Route for Shared Hosting
Route::get('/debug/setup', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return "System Optimized and Migrated Successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/', function () {
    if (Auth::guard('student')->check()) {
        return redirect()->route('student.dashboard');
    }
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('student.login');
});

Route::get('/student/register', [\App\Http\Controllers\StudentRegistrationController::class, 'index'])->name('student.register');
Route::post('/student/register', [\App\Http\Controllers\StudentRegistrationController::class, 'store'])->name('student.register.post');

Route::get('/student/course-register', [\App\Http\Controllers\CourseRegistrationController::class, 'index'])->name('student.course-register');
Route::post('/student/course-register', [\App\Http\Controllers\CourseRegistrationController::class, 'store'])->name('student.course-register.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('guest');
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::resource('courses', \App\Http\Controllers\CourseController::class)->except(['create', 'show', 'edit'])->middleware('auth');
Route::get('/students/template', [\App\Http\Controllers\StudentController::class, 'downloadTemplate'])->name('students.template')->middleware('auth');
Route::post('/students/import', [\App\Http\Controllers\StudentController::class, 'import'])->name('students.import')->middleware('auth');
Route::delete('/students/destroySelected', [\App\Http\Controllers\StudentController::class, 'destroySelected'])->name('students.destroySelected')->middleware('auth');
Route::resource('students', \App\Http\Controllers\StudentController::class)->except(['create', 'show'])->middleware('auth');
Route::get('/students/conduct', [\App\Http\Controllers\StudentConductController::class, 'index'])->name('students.conduct')->middleware('auth');
Route::post('/students/conduct', [\App\Http\Controllers\StudentConductController::class, 'store'])->name('students.conduct.store')->middleware('auth');
Route::delete('/students/conduct/{id}', [\App\Http\Controllers\StudentConductController::class, 'destroy'])->name('students.conduct.destroy')->middleware('auth');
Route::get('/students/{student}', [\App\Http\Controllers\StudentController::class, 'show'])->name('students.show')->middleware('auth');
Route::resource('surveys', \App\Http\Controllers\SurveyController::class)->middleware('auth');
Route::get('/subjects/template', [\App\Http\Controllers\SubjectController::class, 'downloadTemplate'])->name('subjects.template')->middleware('auth');
Route::post('/subjects/import', [\App\Http\Controllers\SubjectController::class, 'import'])->name('subjects.import')->middleware('auth');
Route::resource('subjects', \App\Http\Controllers\SubjectController::class)->except(['create', 'show', 'edit'])->middleware('auth');
Route::resource('timetables', \App\Http\Controllers\TimetableController::class)->except(['create', 'show', 'edit'])->middleware('auth');
Route::resource('documents', \App\Http\Controllers\DocumentController::class)->except(['create', 'show', 'edit'])->middleware('auth');
Route::get('/grades/template', [\App\Http\Controllers\GradeController::class, 'downloadTemplate'])->name('grades.template')->middleware('auth');
Route::post('/grades/import', [\App\Http\Controllers\GradeController::class, 'import'])->name('grades.import')->middleware('auth');
Route::resource('grades', \App\Http\Controllers\GradeController::class)->except(['create', 'show', 'edit'])->middleware('auth');
Route::get('/transcripts', [\App\Http\Controllers\TranscriptController::class, 'index'])->name('transcripts.index')->middleware('auth');
Route::get('/transcripts/download', [\App\Http\Controllers\TranscriptController::class, 'download'])->name('transcripts.download')->middleware('auth');
Route::get('/teachers/template', [\App\Http\Controllers\TeacherController::class, 'downloadTemplate'])->name('teachers.template')->middleware('auth');
Route::post('/teachers/import', [\App\Http\Controllers\TeacherController::class, 'import'])->name('teachers.import')->middleware('auth');
Route::resource('teachers', \App\Http\Controllers\TeacherController::class)->except(['create', 'show', 'edit'])->middleware('auth');
Route::get('/reports/evaluations', [\App\Http\Controllers\ReportController::class, 'evaluations'])->name('reports.evaluations')->middleware('auth');
Route::post('/reports/evaluations/toggle', [\App\Http\Controllers\ReportController::class, 'togglePeerSetting'])->name('reports.evaluations.toggle')->middleware('auth');

// Registration Management
Route::get('/admin/registration', [\App\Http\Controllers\RegistrationManagementController::class, 'index'])->name('admin.registration.index')->middleware('auth');
Route::post('/admin/registration/toggle', [\App\Http\Controllers\RegistrationManagementController::class, 'toggle'])->name('admin.registration.toggle')->middleware('auth');

// Student Portal
Route::get('/student/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login')->middleware('guest:student');
Route::post('/student/login', [StudentLoginController::class, 'login'])->name('student.login.post')->middleware('guest:student');
Route::get('/student/logout', [StudentLoginController::class, 'logout'])->name('student.logout');

Route::middleware(['auth:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Student\StudentPageController::class, 'profile'])->name('profile');
    Route::post('/profile/photo', [\App\Http\Controllers\Student\StudentPageController::class, 'updateProfilePhoto'])->name('profile.updatePhoto');
    Route::get('/timetable', [\App\Http\Controllers\Student\StudentPageController::class, 'timetable'])->name('timetable');
    Route::get('/grades', [\App\Http\Controllers\Student\StudentPageController::class, 'grades'])->name('grades');
    Route::get('/conduct', [\App\Http\Controllers\Student\StudentPageController::class, 'conduct'])->name('conduct');
    Route::get('/surveys', [\App\Http\Controllers\Student\StudentSurveyController::class, 'index'])->name('surveys');
    Route::get('/surveys/{survey}', [\App\Http\Controllers\Student\StudentSurveyController::class, 'show'])->name('surveys.do');
    Route::post('/surveys/{survey}', [\App\Http\Controllers\Student\StudentSurveyController::class, 'store'])->name('surveys.store');
    Route::get('/documents', [\App\Http\Controllers\Student\StudentPageController::class, 'documents'])->name('documents');
    Route::get('/evaluation', [\App\Http\Controllers\Student\StudentEvaluationController::class, 'index'])->name('evaluation');
    Route::get('/evaluation/teacher/{subjectId}/{teacherId}', [\App\Http\Controllers\Student\StudentEvaluationController::class, 'teacherEvaluation'])->name('teacher-evaluation');
    Route::post('/evaluation/teacher/{subjectId}/{teacherId}', [\App\Http\Controllers\Student\StudentEvaluationController::class, 'storeTeacherEvaluation'])->name('teacher-evaluation.store');
    Route::get('/evaluation/peer/{studentId}', [\App\Http\Controllers\Student\StudentEvaluationController::class, 'peerEvaluation'])->name('peer-evaluation');
    Route::post('/evaluation/peer/{studentId}', [\App\Http\Controllers\Student\StudentEvaluationController::class, 'storePeerEvaluation'])->name('peer-evaluation.store');
    Route::get('/change-password', [\App\Http\Controllers\Student\StudentPageController::class, 'changePasswordForm'])->name('change-password');
    Route::post('/change-password', [\App\Http\Controllers\Student\StudentPageController::class, 'updatePassword'])->name('change-password.update');
});
Route::get('/reports/students', [\App\Http\Controllers\ReportController::class, 'students'])->name('reports.students')->middleware('auth');
Route::post('/reports/students/export', [\App\Http\Controllers\ReportController::class, 'exportStudents'])->name('reports.students.export')->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
