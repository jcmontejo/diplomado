<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentInscription extends Model
{
    protected $fillable = [
        'student_id',
        'diplomat_id',
        'generation_id'
    ];
}
