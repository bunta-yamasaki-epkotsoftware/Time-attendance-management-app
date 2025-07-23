<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'attendance_id',
        'request_type',
        'current_clock_in',
        'current_clock_out',
        'requested_clock_in',
        'requested_clock_out',
        'reason',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'current_clock_in' => 'datetime',
            'current_clock_out' => 'datetime',
            'requested_clock_in' => 'datetime',
            'requested_clock_out' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * 申請者（ユーザー）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 対象の勤怠記録
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    /**
     * 申請を審査したユーザー
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
