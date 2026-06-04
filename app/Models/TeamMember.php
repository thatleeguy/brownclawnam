<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $guarded = [];

    protected $casts = [
        'cv'      => 'array',
        'visible' => 'boolean',
    ];

    public function scopeVisible($q)
    {
        return $q->where('visible', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('display_order')->orderBy('id');
    }
}
