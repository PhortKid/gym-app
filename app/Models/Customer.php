<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable=
    [
            'full_name',
            'gender',
            'phone_number',
            'email',
            'nationality',
            'address',
            'start_date',
            'expiry_date',
            'next_of_kin_name',
            'next_of_kin_relation',
            'next_of_kin_phone',
            'payment_plan',
            'health_notes',
            'membership_type_id',
            'assigned_trainer_id',
            'profile_photo',
            'preferred_workout_time',
            'amount',
            'payed_amount',
            'payment_status',
            'payment_method',

           'card_number',
           'body_weight',
           'body_height',
           'bmi',
           'membership_category',
           'programs',
           'exercise_intentions',
           'insurance_category',
    ];

    public function assigned_trainer()
    {
        return $this->belongsTo(User::class, 'assigned_trainer_id');
    }
    
    public function membership_type()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_type_id');
    }

    public function payments()
{
    return $this->hasMany(Payment::class, 'member_id');
}


    

}
