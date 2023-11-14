<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create($data)
 * @method static where(string $string, string $string1, string $now)
 */
class RiderLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'rider_id',
        'lat',
        'long',
        'capture_time',
    ];

    public function rider(): BelongsTo
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }
}
