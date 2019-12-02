<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{   
    protected $table = 'agreements';
    
    protected $fillable = [
        'date',
        'amount',
        'num_pay',
        'status',
        'debt_id',
    ];
}
