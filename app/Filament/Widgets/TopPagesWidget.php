<?php

namespace App\Filament\Widgets;

use App\Models\Capability;
use App\Models\CaseStudy;
use App\Models\Insight;
use App\Models\PageVisit;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class TopPagesWidget extends Widget
{
    protected string $view = 'filament.widgets.top-pages';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -10;

    public function getViewData(): array
    {
        $start    = Carbon::now()->subDays(6)->startOfDay();   // last 7 days inclusive
        $prevEnd  = Carbon::now()->subDays(7)->endOfDay();
        $prevStart= Carbon::now()->subDays(13)->startOfDay();

        $thisWeek = PageVisit::humans()->where('created_at', '>=', $start)->count();
        $lastWeek = PageVisit::humans()->whereBetween('created_at', [$prevStart, $prevEnd])->count();

        $delta = $lastWeek > 0
            ? round((($thisWeek - $lastWeek) / max($lastWeek, 1)) * 100)
            : ($thisWeek > 0 ? 100 : 0);

        // Daily totals for the chart
        $rows = PageVisit::humans()
            ->where('created_at', '>=', $start)
            ->selectRaw("date(created_at) as day, count(*) as c")
            ->groupBy('day')
            ->pluck('c', 'day');

        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::now()->subDays($i)->toDateString();
            $days->push([
                'date'  => $d,
                'count' => (int) ($rows[$d] ?? 0),
                'label' => Carbon::parse($d)->format('D j'),
            ]);
        }

        // Top 10 paths this week, with per-day sparkline
        $top = PageVisit::humans()
            ->where('created_at', '>=', $start)
            ->selectRaw("path, count(*) as c")
            ->groupBy('path')
            ->orderByDesc('c')
            ->limit(10)
            ->get()
            ->map(function ($row) use ($start) {
                $sparkRows = PageVisit::humans()
                    ->where('path', $row->path)
                    ->where('created_at', '>=', $start)
                    ->selectRaw("date(created_at) as day, count(*) as c")
                    ->groupBy('day')
                    ->pluck('c', 'day');

                $spark = [];
                for ($i = 6; $i >= 0; $i--) {
                    $d = Carbon::now()->subDays($i)->toDateString();
                    $spark[] = (int) ($sparkRows[$d] ?? 0);
                }

                return (object) [
                    'path'    => $row->path,
                    'count'   => (int) $row->c,
                    'title'   => self::resolveTitle($row->path),
                    'spark'   => $spark,
                ];
            });

        $totalEver = PageVisit::humans()->count();
        $bots      = PageVisit::where('is_bot', true)->where('created_at', '>=', $start)->count();

        return [
            'thisWeek'   => $thisWeek,
            'lastWeek'   => $lastWeek,
            'delta'      => $delta,
            'days'       => $days,
            'maxDay'     => max($days->pluck('count')->max() ?: 1, 1),
            'top'        => $top,
            'maxRow'     => max($top->pluck('count')->max() ?: 1, 1),
            'totalEver'  => $totalEver,
            'bots'       => $bots,
        ];
    }

    protected static array $titleCache = [];

    public static function resolveTitle(string $path): string
    {
        if (isset(self::$titleCache[$path])) {
            return self::$titleCache[$path];
        }

        $title = self::computeTitle($path);
        self::$titleCache[$path] = $title;

        return $title;
    }

    protected static function computeTitle(string $path): string
    {
        $statics = [
            '/'             => 'Home',
            '/capabilities' => 'Capabilities — index',
            '/work'         => 'Work — archive',
            '/briefings'    => 'Briefings — archive',
            '/firm'         => 'The firm',
            '/contact'      => 'Contact',
        ];
        if (isset($statics[$path])) {
            return $statics[$path];
        }

        $segments = explode('/', trim($path, '/'));
        if (count($segments) === 2) {
            [$head, $slug] = $segments;
            return match ($head) {
                'capabilities' => optional(Capability::where('slug', $slug)->first())->title ?? "Capability: {$slug}",
                'work'         => optional(CaseStudy::where('slug', $slug)->first())->title  ?? "Work: {$slug}",
                'briefings'    => optional(Insight::where('slug', $slug)->first())->title    ?? "Briefing: {$slug}",
                default        => $path,
            };
        }

        return $path;
    }
}
