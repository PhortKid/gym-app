<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'time_in',
        'time_out',
        'workout_area',
        'trainer_id',
    ];

    /**
     * Relationship: Attendance belongs to a Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class,'member_id');
    }

    /**
     * Relationship: Attendance may be assisted by a Trainer
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
