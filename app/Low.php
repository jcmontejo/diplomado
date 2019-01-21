<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Low extends Model
{
    protected $fillable = [
        'reason',
        'comments',
        'studentinscriptions_id'
    ];

    public function inscription()
    {
        return $this->belongsTo('App\StudentInscription');
    }
}
