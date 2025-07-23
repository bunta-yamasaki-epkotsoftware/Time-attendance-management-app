<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(app()->isLocal()){
            Department::factory()
            ->count(10)
            ->sequence(function ($sequence) {
                return [
                    'name' => sprintf('部署_%02d', $sequence->index + 1),
                    'description' => sprintf('部署の説明_%02d', $sequence->index + 1),
                    'manager_id' => null, // 初期はnull、後で更新する
                ];
            })
            ->create();
        }
    }
}
