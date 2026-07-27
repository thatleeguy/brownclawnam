<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function scopePublished($q)
    {
        return $q->where('published', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('display_order')->orderByDesc('year')->orderBy('id');
    }
}
