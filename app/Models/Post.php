<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'post_id';
    protected $fillable = [
        'media',
        'content',
        'type'
    ];

    public function likes()
    {
        return $this->belongsToMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'post_id');
    }

    public function mediaURL() {
        $post->media = Storage::disk('s3')->url($post->media);
    }
}
