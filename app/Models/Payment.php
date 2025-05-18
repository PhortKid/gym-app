<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'payment_date',
        'amount',
        'payment_method',
        'invoice_number',
    ];

    protected $casts = [
       
        'amount' => 'decimal:2',
      
    ];

    /**
     * Relationship: Payment belongs to a customer (member)
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'member_id');
    }
}
