<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(app()->isLocal()) {
            Role::factory()
            ->count(10)
            ->sequence(function ($sequence) {
                return [
                    'name' => sprintf('役職_%02d', $sequence->index + 1),
                    'level' => $sequence->index + 1, // 役職のレベルを設定
                ];
        })
        ->create();
        }
    }
}