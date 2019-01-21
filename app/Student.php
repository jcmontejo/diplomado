<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'enrollment',
        'curp',
        'name',
        'last_name',
        'mother_last_name',
        'facebook',
        'interested',
        'birthdate',
        'sex',
        'phone',
        'address',
        'email',
        'state',
        'city',
        'profession',
        'documents',
        'status',
        'keep_going',
        'color',
        'user_id'
    ];

    public function document()
    {
        return $this->hasOne('App\Document');
    }
}
