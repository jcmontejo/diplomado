<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'name_diplomat',
        'number_generation',
        'number_payments',
        'note',
        'status',
        'diplomat_id'
    ];
}
