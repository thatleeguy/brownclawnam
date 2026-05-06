<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'spec_row'             => 'array',
        'position_paragraphs'  => 'array',
        'kpi_metrics'          => 'array',
        'criticality_checks'   => 'array',
        'criticality_register' => 'array',
    ];

    /** Singleton accessor — always returns the row, creating an empty one if missing. */
    public static function current(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }
}
