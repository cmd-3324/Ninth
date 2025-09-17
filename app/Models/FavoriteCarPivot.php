<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FavoriteCarPivot extends Model
{
    protected $table = "cars_favorites";
    public $timestamps = true;
    
    protected $fillable = [
        'car_id',
        'UserID',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}