<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    protected $fillabel = [
        'commission',
        'full_price',
        'status',
        'student_inscription_id',
        'user_id',
    ];
}
