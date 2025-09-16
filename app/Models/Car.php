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

// از این میتونم برای اینجور بنیفیت ها راحت و سریغ تر استفاده کنم ، اگر بین get  و اتریبیت اسم اون متفیر رو بنویسم مثات Benifit  توی فاایل بلید میتونیم ازتش استفاد کنم 
    //https://chatgpt.com/c/68c83795-bfdc-832e-9440-00c7ad7c1201
public function getBenefitAttribute()
{
    $price = $this->price ?? 0;
    $totalBoughtNum = CarUse::where('car_id', $this->car_id)->sum('bought_num') ?? 0;
    return $price * $totalBoughtNum;
}


public function carBuyers(): BelongsToMany
{
    return $this->belongsToMany(
        CarUser::class,
        'car_user',
        'car_id',
        'UserID'

    )->withTimestamps();
}


    public function getTotalBuyersAttribute(): int
    {
        return $this->carBuyers()->count();
    }




public function updateSalesData(): void
{
    $userCount = $this->carBuyers()->count();
    $totalStock = $this->sell_number + $this->available_as;
    $available = $totalStock - $userCount;
    if ($available < 0) {
        $available = 0;
    }

    $this->sell_number = $userCount;
    $this->available_as = $available;
    $this->save();
}

}
