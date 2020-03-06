<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocentPay extends Model
{
    protected $fillable = [
        'amount',
        'generation_id'
    ];
}
