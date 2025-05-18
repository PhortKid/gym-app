<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'specialization',
        'salary',
        'work_schedule',
        'phone_number',
        'work_schedule',
        'position'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeStaff($query)
    {
        return $query->whereIn('role', ['trainer', 'receptionist', 'cleaner']);
    }

    // Scope: Specific staff role
    public function scopeTrainers($query)
    {
        return $query->where('role', 'trainer');
    }

    // Relationship: Members assigned to this trainer
    public function assignedMembers()
    {
        return $this->hasMany(Member::class, 'assigned_trainer_id');
    }

    // Relationship: Classes taught by trainer
    public function classes()
    {
        return $this->hasMany(GymClass::class, 'trainer_id');
    }

    // Relationship: Attendance records (if assisted)
    public function assistedSessions()
    {
        return $this->hasMany(Attendance::class, 'trainer_id');
    }

    public function customers()
{
    return $this->hasMany(Customer::class, 'assigned_trainer_id');
}

}
