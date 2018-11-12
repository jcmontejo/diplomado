<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'mother_last_name',
        'birthdate',
        'sex',
        'phone',
        'address',
        'email',
        'profession',
        'documents'
    ];

    public function document()
    {
        return $this->hasOne('App\Document');
    }
}
