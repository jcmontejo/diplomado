<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'concept',
        'amount',
        'description',
        'voucher',
        'user_id',
        'account_id'
    ];
}
