<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'subject',
        'message',
        'receiver',
        'receiver_id',
        'user_id'
    ];
}
