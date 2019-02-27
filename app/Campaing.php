<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaing extends Model
{
    protected $fillable = [
        'subject',
        'name',
        'html_url',
        'send_date',
        'message',
        'type',
        'status',
        'user_id'
    ];
}
