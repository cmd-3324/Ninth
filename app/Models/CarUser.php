<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CarUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'carsusers';
    protected $primaryKey = 'UserID';
    public $incrementing = true;

    protected $fillable = [
        'UserName',
        'email',
        'password',
        'phone_number',
        'Active',
        'Location',
        'Avatar'
    ];

    /**
     * The cars that belong to the user (many-to-many relationship)
     */
public function cars(): BelongsToMany
{
    return $this->belongsToMany(
        related: Car::class,
        table: 'car_user',
        foreignPivotKey: 'UserID',
        relatedPivotKey: 'car_id'
    )->withTimestamps(); 
}
        public function likedComments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comment_likes')
                    ->withTimestamps();
    }
}
