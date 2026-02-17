<?php

/**
 * ===================================================================
 * TEMPORARY SETUP ROUTES - ลบไฟล์นี้หลังจาก setup เสร็จ!
 * ===================================================================
 * 
 * 1. https://your-domain.com/setup-meims/clear-cache
 * 2. https://your-domain.com/setup-meims/seed-admin
 * 3. https://your-domain.com/setup-meims/test-leave-db
 * 4. https://your-domain.com/setup-meims/inspect-leave-users
 * 5. https://your-domain.com/setup-meims/migrate (สร้างฟิลด์ leave_user_id)
 * 6. https://your-domain.com/setup-meims/sync-students (ดึงข้อมูล นร. จาก Leave)
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Route::prefix('setup-meims')->group(function () {

    // 1. Clear all cache
    Route::get('/clear-cache', function () {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return response()->json(['status' => '✅ เคลียร์ Cache สำเร็จ']);
    });

    // 2. Seed admin user
    Route::get('/seed-admin', function () {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@meims.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        return response()->json(['status' => '✅ สร้าง Admin User สำเร็จ']);
    });

    // 3. Test leave database connection
    Route::get('/test-leave-db', function () {
        try {
            $userCount = DB::connection('leave_db')->table('users')->count();
            return response()->json([
                'status' => '✅ เชื่อมต่อสำเร็จ',
                'users_count' => $userCount
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    // 4. Inspect Leave System Users Structure
    Route::get('/inspect-leave-users', function () {
        try {
            $columns = DB::connection('leave_db')->getSchemaBuilder()->getColumnListing('users');
            $users = DB::connection('leave_db')->table('users')->limit(5)->get();
            return response()->json(['columns' => $columns, 'sample_users' => $users]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });


    // 5. Run Specific Migration (Add leave_user_id Only)
    Route::get('/migrate', function () {
        try {
            $path = 'database/migrations/2026_02_16_150744_add_leave_user_id_to_students_table.php';
            Artisan::call('migrate', [
                '--path' => $path,
                '--force' => true
            ]);
            return response()->json([
                'status' => '✅ Migrate (เฉพาะไฟล์ leave_user_id) สำเร็จ',
                'output' => Artisan::output(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    // 6. Sync Students (Run Seeder)
    Route::get('/sync-students', function () {
        try {
            Artisan::call('db:seed', ['--class' => 'SyncLeaveStudentsSeeder', '--force' => true]);
            return response()->json(['status' => '✅ Sync ข้อมูลนักเรียนสำเร็จ', 'output' => Artisan::output()]);
        } catch (\Exception $e) {
            // Check if Seeder file exists first
            if (!file_exists(database_path('seeders/SyncLeaveStudentsSeeder.php'))) {
                return response()->json(['error' => 'ไม่พบไฟล์ SyncLeaveStudentsSeeder.php กรุณาอัพโหลดก่อน!'], 404);
            }
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

});
