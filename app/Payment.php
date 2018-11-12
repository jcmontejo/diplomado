<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'concept',
        'date',
        'amount_payable',
        'student_id',
        'generation_id',
        'diplomat_id',
        'status',
        'debt_id'
    ];
}
