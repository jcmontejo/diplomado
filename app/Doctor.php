<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'email'
    ];

    public function getFullnameAttribute()
    {
        return "{$this->name} {$this->lastname}";
    }
}
