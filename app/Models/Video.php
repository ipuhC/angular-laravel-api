<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'video_name',
        'likes',
        'dislikes',
        'views',
        'upload_date',
        'username',
        'video_file',
        'thumbnail',
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
