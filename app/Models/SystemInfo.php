<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemInfo extends Model
{
    protected $table = 'system_info';


    protected $fillable = [
        'name',
        'logo',
        'email',
        'description',
        'phone_number',
        'address'
      ];
}
