<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chat',
        'author',
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat');
    }
}
