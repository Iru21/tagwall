<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostAttachment extends Model
{
    protected $fillable = ['post_id', 'path', 'is_image'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function path()
    {
        return Attribute::make(
            get: fn ($value) => Storage::disk('public')->url('attachments/' . $value)
        );
    }
}
