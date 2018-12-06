<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentReceived extends Model
{
    protected $fillable = [
        'diplomat_id',
        'generation_id',
        'student_id',
        'date_payment',
        'observation',
        'payment_method',
        'destination_account',
        'account_type',
        'amount',
        'discount',
        'total',
        'debt_id'
    ];
}
