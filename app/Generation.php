<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'name_diplomat',
        'number_generation',
        'start_date',
        'number_payments',
        'note',
        'status',
        'docent',
        'docent_id',
        'diplomat_id'
    ];
}
