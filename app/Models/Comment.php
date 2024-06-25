<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'video_id', 'user_id', 'body'
    ];

    // Un comentario pertenece a un video
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
 // Un comentario pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
