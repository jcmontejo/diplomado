<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'proof_of_address',
        'proof_of_studies',
        'student_id'
    ];

    public function student()
    {
        return $this->belongsTo('App\Student');
    }
}
