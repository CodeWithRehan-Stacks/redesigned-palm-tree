<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Raise extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'note_id',
        'quote_text',
        'content',
        'image_path',
        'likes_count',
        'reposts_count',
        'comments_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
