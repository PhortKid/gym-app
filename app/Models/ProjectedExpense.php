<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectedExpense extends Model
{
    use HasFactory;

    protected $table = 'projected_expenses';

    protected $fillable = [
        'daily',
        'monthly',
        'annual',
        'expense_id',
    ];

    public function expensetype()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_id'); 
    }
}
