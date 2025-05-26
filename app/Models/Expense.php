<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'payment_method',
        'description',
        'amount',
        'date',
        'category_id',
        'status',
        'payed_to',
        'income_id',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function income_category()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_id');
    }
}
