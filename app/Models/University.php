<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'country', 'logo'];

    public function users() { return $this->hasMany(User::class); }
    public function notes() { return $this->hasMany(Note::class); }
}
