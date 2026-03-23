<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected static function booted() {
        static::created(function ($user) {
            $user->settings()->create();
        });
    }

    protected $fillable = [
        'username',
        'password',
        'is_admin',
        'activated_at',
        'settings',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'activated_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function settings() {
        return $this->hasOne(UserSettings::class);
    }
}
