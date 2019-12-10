<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    protected $fillable = [
        'date',
        'start',
        'end',
        'patient',
        'doctor_id',
        'room_id',
        'observation'
    ];
}
