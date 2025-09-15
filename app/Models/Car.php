<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Car extends Model
{
    use HasFactory;

    protected $primaryKey = 'car_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'cars';

    protected $fillable = [
        'name',
        'price',
        'engine',
        'discription',
        'available_as',
        'sell_number'
    ];

public function getBenefitAttribute(): int
{
    return $this->price * $this->carBuyers()->count();
}

public function carBuyers(): BelongsToMany
{
    return $this->belongsToMany(
        CarUser::class,
        'car_user',
        'car_id',
        'UserID'
<<<<<<< HEAD
    )->withTimestamps(); 
}

  
=======
    )->withTimestamps();
}


>>>>>>> 635f706 (Initial commit)
    public function getTotalBuyersAttribute(): int
    {
        return $this->carBuyers()->count();
    }

<<<<<<< HEAD
   
=======

>>>>>>> 635f706 (Initial commit)
public function updateSalesData(): void
{
    $userCount = $this->carBuyers()->count();
    $totalStock = $this->sell_number + $this->available_as;
<<<<<<< HEAD
    
=======

>>>>>>> 635f706 (Initial commit)
    $available = $totalStock - $userCount;
    if ($available < 0) {
        $available = 0;
    }

    $this->sell_number = $userCount;
    $this->available_as = $available;
    $this->save();
}
<<<<<<< HEAD
=======

>>>>>>> 635f706 (Initial commit)
}
