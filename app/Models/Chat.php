<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $hidden = ['pivot'];

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_chats');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat');
    }
}
