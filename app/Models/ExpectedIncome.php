<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpectedIncome extends Model
{
    use HasFactory;

    protected $table = 'expected_income';

    protected $fillable = [
        'daily',
        'monthly',
        'annual',
        'income_id',
    ];

    public function incomecategory()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_id'); 
    }
}
