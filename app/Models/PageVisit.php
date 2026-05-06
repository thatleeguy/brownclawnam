<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'is_bot'     => 'boolean',
        'created_at' => 'datetime',
    ];

    public function scopeHumans($q)
    {
        return $q->where('is_bot', false);
    }
}
