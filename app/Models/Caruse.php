<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Caruse extends Model
{
    use HasFactory;
    protected $table = 'car_user';
    protected $fillable = [
    'car_id',
    'UserID',

];
}
