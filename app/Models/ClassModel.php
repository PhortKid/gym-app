<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes'; // kwa sababu "class" ni reserved keyword, tunatumia jina lingine kwa model

    protected $fillable = [
        'name',
        'trainer_id',
        'scheduled_date',
        'scheduled_time',
        'duration_minutes',
        'max_capacity',
        'current_enrollments',
        'venue',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'scheduled_time' => 'datetime:H:i:s', // inasaidia parsing ya muda
    ];

    /**
     * Relationship: Class belongs to a trainer (user)
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
