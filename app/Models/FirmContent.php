<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmContent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'engagement_steps' => 'array',
    ];

    /** Singleton accessor — always returns the row, creating an empty one if missing. */
    public static function current(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }
}
