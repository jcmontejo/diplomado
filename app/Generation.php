<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'name_diplomat',
        'number_generation',
        'number_students',
        'cost',
        'start_date',
        'commision',
        'full_price',
        'note',
        'status',
        'docent',
        'docent_id',
        'diplomat_id'
    ];
}
