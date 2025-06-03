<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $primaryKey = 'follow_id';

    protected $fillable = [
        'followed_id',
        'follower_id',
    ];
}
