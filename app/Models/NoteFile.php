<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteFile extends Model
{
    protected $fillable = [
        'note_id',
        'file_path',
        'file_type',
        'original_name',
        'mime_type',
        'size',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
