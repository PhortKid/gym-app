<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $table = 'income_category';

    protected $fillable = [
        'name',
    ];

    public function incomes()
    {
        return $this->hasMany(Income::class, 'category_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'income_id');
    }
}
