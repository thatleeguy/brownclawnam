<?php

namespace App\Filament\Widgets;

use App\Models\Insight;
use Filament\Widgets\Widget;

class PublishToMiningAndEnergyWidget extends Widget
{
    protected string $view = 'filament.widgets.publish-to-mining-and-energy';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -5;

    public function getViewData(): array
    {
        $publishedCount   = Insight::published()->count();
        $syndicatedCount  = Insight::published()->whereNotNull('syndicated_at')->count();
        $unsyndicated     = Insight::published()->whereNull('syndicated_at')->orderByDesc('published_at')->limit(5)->get();
        $latestSyndicated = Insight::whereNotNull('syndicated_at')->orderByDesc('syndicated_at')->first();

        return [
            'publishedCount'   => $publishedCount,
            'syndicatedCount'  => $syndicatedCount,
            'unsyndicatedCount'=> $unsyndicated->count(),
            'unsyndicated'     => $unsyndicated,
            'latestSyndicated' => $latestSyndicated,
        ];
    }
}
