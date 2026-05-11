<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'first_name', 
        'last_name', 
        'bio', 
        'profile_picture', 
        'banner_image', 
        'username', 
        'email', 
        'password', 
        'university', 
        'skills', 
        'subjects', 
        'social_links',
        'role',
        'is_private'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
        'subjects' => 'array',
        'social_links' => 'array',
        'is_private' => 'boolean',
    ];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')->withTimestamps();
    }

    public function likedNotes()
    {
        return $this->belongsToMany(Note::class, 'note_likes')->withTimestamps();
    }

    public function savedNotes()
    {
        return $this->belongsToMany(Note::class, 'note_saves')->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function isFollowedBy(User $user)
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    public function mutualFollowers()
    {
        return $this->followers()->whereIn('follower_id', $this->following()->pluck('following_id'));
    }

    /**
     * Get IDs of users who follow this user.
     */
    public function followerIds()
    {
        return $this->followers()->pluck('follower_id');
    }

    /**
     * Get IDs of users this user follows.
     */
    public function followingIds()
    {
        return $this->following()->pluck('following_id');
    }
}
