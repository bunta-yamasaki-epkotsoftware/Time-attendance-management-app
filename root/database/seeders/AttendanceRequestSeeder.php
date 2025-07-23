<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AttendanceRequest;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            $attendances = Attendance::all();
            $users = User::all();

            // // 依存データの存在チェック
            // if ($attendances->isEmpty()) {
            //     $this->command->warn('勤怠データが存在しません。先にAttendanceSeederを実行してください。');
            //     return;
            // }

            // if ($users->isEmpty()) {
            //     $this->command->warn('ユーザーデータが存在しません。先にUserSeederを実行してください。');
            //     return;
            // }

            AttendanceRequest::factory()
            ->count(20)
            ->sequence(function ($sequence) use ($attendances, $users) {
                $attendance = $attendances->random();
                $requestType = fake()->randomElement(['correction', 'vacation', 'sick']);

                // 申請タイプに応じてデータを設定
                $data = [
                    'user_id' => $attendance->user_id, // 勤怠記録の所有者が申請
                    'attendance_id' => $attendance->id,
                    'request_type' => $requestType,
                    'reason' => $this->getReasonByType($requestType),
                ];

                // 修正申請の場合は時刻情報を追加
                if ($requestType === 'correction') {
                    $data['current_clock_in'] = $attendance->clock_in;
                    $data['current_clock_out'] = $attendance->clock_out;
                    $data['requested_clock_in'] = Carbon::parse($attendance->clock_in)->subMinutes(fake()->numberBetween(10, 60));
                    $data['requested_clock_out'] = Carbon::parse($attendance->clock_out)->addMinutes(fake()->numberBetween(10, 60));
                }

                return $data;
            })
            ->create();

            // 一部の申請を承認/却下状態にする
            $this->updateRequestStatuses();
        }
    }

    /**
     * 申請タイプに応じた理由を生成
     */
    private function getReasonByType(string $type): string
    {
        $reasons = [
            'correction' => [
                '電車遅延のため遅刻しました',
                '残業が長引いたため退勤時刻を修正します',
                '打刻を忘れていました',
                '会議が早く終わったため早めに退社しました',
                '客先訪問のため直行しました'
            ],
            'vacation' => [
                '有給休暇を取得します',
                '家族の用事のため休暇を取ります',
                '病院に行くため半休を取ります',
                'リフレッシュ休暇を取得します',
                '私用のため休暇を申請します'
            ],
            'sick' => [
                '体調不良のため休みます',
                '発熱のため自宅療養します',
                '病院での検査のため休みます',
                '家族の看病のため休みます',
                '風邪の症状があるため休みます'
            ]
        ];

        return fake()->randomElement($reasons[$type]);
    }

    /**
     * 申請状況を更新（一部を承認/却下にする）
     */
    private function updateRequestStatuses(): void
    {
        $requests = AttendanceRequest::all();
        $reviewers = User::where('is_admin', true)->get();

        if ($reviewers->isEmpty()) {
            $reviewers = User::limit(3)->get(); // 管理者がいない場合は最初の3人
        }

        // 70%を承認、20%を却下、10%は承認待ちのまま
        $requests->each(function ($request) use ($reviewers) {
            $rand = fake()->numberBetween(1, 10);

            if ($rand <= 7) {
                // 承認
                $request->update([
                    'status' => 'approved',
                    'reviewed_by' => $reviewers->random()->id,
                    'reviewed_at' => fake()->dateTimeBetween('-1 week', 'now'),
                    'review_comment' => fake()->optional(0.5)->randomElement([
                        '承認しました',
                        '問題ありません',
                        '了解しました',
                        '承認いたします'
                    ])
                ]);
            } elseif ($rand <= 9) {
                // 却下
                $request->update([
                    'status' => 'rejected',
                    'reviewed_by' => $reviewers->random()->id,
                    'reviewed_at' => fake()->dateTimeBetween('-1 week', 'now'),
                    'review_comment' => fake()->randomElement([
                        '詳細な理由が必要です',
                        '承認できません',
                        '再申請してください',
                        '根拠が不十分です'
                    ])
                ]);
            }
            // 残り10%はpendingのまま（何もしない）
        });
    }
}
