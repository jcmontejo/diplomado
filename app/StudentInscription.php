<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class StudentInscription extends Model
{   
    use Notifiable;

    protected $fillable = [
        'student_id',
        'diplomat_id',
        'generation_id',
        'discount',
        'final_cost',
        'first_payment',
        'comments',
        'status',
        'amount_of_payments',
        'periodicity',
        'type_of_inscription',
        'read'
    ];

    public function low()
    {
        return $this->hasOne('App\Low');
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        $intl_number = preg_replace('/^07/','52', '9612579168');
        return $intl_number;
    }

    public function routeNotificationForMail()
    {
        return 'jncrlsmontejo@gmail.com';
    }
}
