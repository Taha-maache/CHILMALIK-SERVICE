<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = [
        'key',
        'label',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    protected static ?array $priceCache = null;

    public static function getPrice(string $key, float $default): float
    {
        if (static::$priceCache === null) {
            static::$priceCache = static::pluck('price', 'key')
                ->map(fn ($price) => (float) $price)
                ->all();
        }

        return static::$priceCache[$key] ?? $default;
    }
}
