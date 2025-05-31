<?php
// app/Models/Invoice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone_number', 'start_date', 'expiry_date',
        'gender', 'amount', 'paid_amount', 'payment_plan', 'assigned_trainer'
    ];
}

