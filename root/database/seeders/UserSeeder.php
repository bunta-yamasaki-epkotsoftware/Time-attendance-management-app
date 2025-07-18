<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(app()->isLocal()){
            // 部署と役職のIDを取得
            $departments = Department::all();
            $roles = Role::all();

            User::factory()
            ->count(10)
            ->sequence(function ($sequence) use ($departments, $roles) {
                return [
                    'employee_id' => sprintf('EMP%04d', $sequence->index + 1), // EMP0001, EMP0002...
                    'name' => sprintf('test_%02d', $sequence->index + 1),
                    'email' => sprintf('test_%02d@test.com', $sequence->index + 1), // emailカラム名に修正
                    'password' => Hash::make('test'),
                    'department_id' => $departments->random()->id ?? null, // ランダムな部署を割り当て
                    'role_id' => $roles->random()->id ?? null, // ランダムな役職を割り当て
                    'is_admin' => $sequence->index === 0, // 最初のユーザーのみ管理者
                    'hire_date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'), // 過去2年以内の入社日
                    'is_active' => true,
                    // 'created_at' => '2025-07-01 08:15:15', //Timestampsは不要（Laravelが自動設定）
                    // 'updated_at' => '2025-07-18 08:15:15', //Timestampsは不要（Laravelが自動設定）
                ];
            })
            ->create();
        }
    }
}
