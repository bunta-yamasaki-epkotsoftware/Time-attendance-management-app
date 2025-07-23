<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,  // 1. 部署（依存なし）
            RoleSeeder::class,        // 2. 役職（依存なし）
            UserSeeder::class,        // 3. ユーザー（部署・役職に依存）
            AttendanceSeeder::class,  // 4. 勤怠（ユーザーに依存）
            AttendanceRequestSeeder::class, // 5. 申請（勤怠に依存）
        ]);
    }
}
