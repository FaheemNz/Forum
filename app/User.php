<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Logic
    public function isAdmin()
    {
        return $this->role == 1;
    }
    
    // Accessors
    public function getAvatarPathAttribute($value): string
    {
        return asset($value ?? 'avatars/Default.png');
    }

    // Relationships
    public function threads()
    {
        return $this->hasMany('App\Thread')->latest();
    }

    public function activity()
    {
        return $this->hasMany('App\Activity');
    }

    public function lastReply()
    {
        return $this->hasOne('App\Reply')->latest();
    }
}
