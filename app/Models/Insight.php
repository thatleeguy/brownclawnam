<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Insight extends Model implements Feedable
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    protected $casts = [
        'is_lead'       => 'boolean',
        'published_at'  => 'datetime',
        'syndicated_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($q)
    {
        return $q->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeOrdered($q)
    {
        return $q->orderByDesc('is_lead')->orderByDesc('published_at');
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id'         => (string) $this->id,
            'title'      => $this->title,
            'summary'    => (string) $this->excerpt,
            'updated'    => $this->updated_at,
            'link'       => route('briefings.show', $this),
            'authorName' => 'Connor Schriver',
            'authorEmail'=> 'info@brownclawam.ca',
        ]);
    }

    public static function getFeedItems()
    {
        return self::published()->ordered()->limit(50)->get();
    }
}
