<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($data)
 * @method static find($restaurantId)
 */
class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lat',
        'long'
    ];
}
