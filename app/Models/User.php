<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username'
    ];

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'users_chats');
    }
}
