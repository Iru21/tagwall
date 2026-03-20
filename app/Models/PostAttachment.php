<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostAttachment extends Model
{
    protected $fillable = ['post_id', 'path', 'is_image', 'alt', 'is_nsfw'];

    protected $casts = [
        'is_image' => 'boolean',
        'is_nsfw' => 'boolean',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function path(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::disk('public')->url($value)
        );
    }

    public function alt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? pathinfo($this->path, PATHINFO_FILENAME)
        );
    }
}
