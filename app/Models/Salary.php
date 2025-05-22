<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    // Define the table if the name is not automatically inferred
    protected $table = 'salary';

    // Define the fillable attributes to avoid mass assignment exception
    protected $fillable = [
        'user_id',
        'basic_salary',
        'loan_deductions',
        'other_deduction',
        'date',
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
