<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'work_date',
        'clock_in',
        'clock_out',
        'break_start',
        'break_end',
        'status',
        'location_lat',
        'location_lng',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'clock_in' => 'datetime',
            'clock_out' => 'datetime',
            'break_start' => 'datetime',
            'break_end' => 'datetime',
            'approved_at' => 'datetime',
            'total_work_hours' => 'decimal:2',
            'total_break_hours' => 'decimal:2',
            'location_lat' => 'decimal:8',
            'location_lng' => 'decimal:8',
        ];
    }

    /**
     * この勤怠記録の所有者（ユーザー）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この勤怠記録を承認したユーザー
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * この勤怠記録に関連する申請
     */
    public function attendanceRequests()
    {
        return $this->hasMany(AttendanceRequest::class);
    }

    /**
     * ユーザーの部署（ユーザー経由でアクセス）
     */
    public function department()
    {
        return $this->user()->with('department');
    }
}
