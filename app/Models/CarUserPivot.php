<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CarUserPivot extends Pivot
{
    protected $table = 'car_user';
    public $timestamps = true;

    protected $fillable = [
        'UserID',
        'car_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

   
}
