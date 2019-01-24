<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diplomat extends Model
{
    protected $fillable = [
        'name',
        'key',
        'cost',
        'maximum_cost'
    ];
}
