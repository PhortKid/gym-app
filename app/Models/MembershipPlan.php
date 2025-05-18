<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'cost',
        'access_rights',
        'discount_offer',
    ];

    protected $casts = [
        'access_rights' => 'array', // allows automatic JSON encode/decode
        'cost' => 'decimal:2',
        'discount_offer' => 'decimal:2',
    ];

 
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
