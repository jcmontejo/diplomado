<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'mother_last_name',
        'birthdate',
        'sex',
        'phone',
        'email',
        'address',
        'joining_date',
        'key_bank',
        'number_target_bank',
        'name_bank'
    ];
}
