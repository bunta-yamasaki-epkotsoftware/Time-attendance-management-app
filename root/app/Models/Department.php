<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'manager_id',
    ];

    /**
     * この部署に属するユーザー（一般社員）
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * 部署長（manager_idで指定されたユーザー）
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
