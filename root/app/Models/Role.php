<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'level',
    ];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
        ];
    }

    public function users()
    {
        // 役職は複数のユーザーに関連付けられる
        return $this->hasMany(User::class);
    }
}
