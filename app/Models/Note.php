<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'cover_image',
        'visibility',
        'views_count',
        'likes_count',
        'saves_count',
        'university_id',
        'subject_id',
        'status',
        'ai_score',
        'is_premium',
        'downloads_count',
        'moderator_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function files()
    {
        return $this->hasMany(NoteFile::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(NoteComment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'note_likes')->withTimestamps();
    }

    public function saves()
    {
        return $this->belongsToMany(User::class, 'note_saves')->withTimestamps();
    }

    /**
     * Calculate trending score based on engagement and time decay.
     */
    public function calculateTrendingScore()
    {
        $weightLikes = 2;
        $weightComments = 5;
        $weightSaves = 6;
        $weightViews = 0.1;

        $engagement = ($this->likes_count * $weightLikes) + 
                      ($this->comments_count * $weightComments) + 
                      ($this->saves_count * $weightSaves) + 
                      ($this->views_count * $weightViews);

        // Time decay: Gravity = 1.5, T = hours since creation
        $hoursSinceCreation = $this->created_at->diffInHours(now());
        $score = $engagement / pow($hoursSinceCreation + 2, 1.5);

        return $score;
    }
    public function university() { return $this->belongsTo(University::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function downloads() { return $this->hasMany(Download::class); }
}
