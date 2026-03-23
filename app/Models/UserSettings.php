<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    protected $fillable = [
        'user_id',
        'settings'
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
        ];
    }

     public function user() {
         return $this->belongsTo(User::class);
     }
}
