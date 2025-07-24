<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(app()->isLocal()) {
            $users = User::all();

            Attendance::factory()
            ->count(50)
            ->sequence(function ($sequence) use ($users) {
                $workDate = fake()->dateTimeBetween('-1 month', 'now');
                $clockIn = Carbon::parse($workDate)->setTime(9, 0, 0)->addMinutes(fake()->numberBetween(-30, 30));
                $clockOut = (clone $clockIn)->addHours(8)->addMinutes(fake()->numberBetween(-60, 60));

                // 休憩時間の設定
                $breakStart = (clone $clockIn)->addHours(4)->addMinutes(fake()->numberBetween(-30, 30));
                $breakEnd = (clone $breakStart)->addHour();

                // 労働時間の計算
                $totalWorkMinutes = $clockOut->diffInMinutes($clockIn) - $breakEnd->diffInMinutes($breakStart);
                $totalWorkHours = round($totalWorkMinutes / 60, 2);

                return [
                    'user_id' => $users->random()->id,
                    'work_date' => $workDate->format('Y-m-d'),
                    'clock_in' => $clockIn->format('H:i'),
                    'clock_out' => $clockOut->format('H:i'),
                    'break_start' => $breakStart->format('H:i'),
                    'break_end' => $breakEnd->format('H:i'),
                    'total_work_hours' => $totalWorkHours,
                    'total_break_hours' => 1.00, // 1時間固定
                    'status' => fake()->randomElement(['working', 'completed', 'absent']),
                    'location_lat' => fake()->latitude(35.6, 35.7), // 東京周辺
                    'location_lng' => fake()->longitude(139.6, 139.8), // 東京周辺
                    'notes' => fake()->optional(0.3)->sentence(), // 30%の確率でメモ
                ];
            })
            ->create();
        }
    }
}
