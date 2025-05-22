<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory;

    protected $table = 'income';

    protected $fillable = [
        'description',
        'amount',
        'date',
        'category_id',
        'amount_spent',
        'payment_type',
    ];

    public function category()
    {
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }
}
