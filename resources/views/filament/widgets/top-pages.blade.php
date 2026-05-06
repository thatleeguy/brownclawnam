@php
    /** @var int $thisWeek */
    /** @var int $lastWeek */
    /** @var int $delta */
    /** @var \Illuminate\Support\Collection $days */
    /** @var int $maxDay */
    /** @var \Illuminate\Support\Collection $top */
    /** @var int $maxRow */
    /** @var int $totalEver */
    /** @var int $bots */

    // Build sparkline path for the daily chart
    $w = 100; $h = 36;
    $points = [];
    foreach ($days as $i => $d) {
        $x = $days->count() === 1 ? 0 : ($i / ($days->count() - 1)) * $w;
        $y = $h - ($d['count'] / max($maxDay, 1)) * ($h - 4);
        $points[] = round($x, 2) . ',' . round($y, 2);
    }
    $linePath  = 'M ' . implode(' L ', $points);
    $areaPath  = $linePath . " L {$w},{$h} L 0,{$h} Z";

    $deltaSign = $delta >= 0 ? '+' : '';
    $deltaArrow = $delta >= 0 ? '▲' : '▼';
@endphp

<x-filament-widgets::widget>
    <style>
        .tp-card {
            position: relative;
            background: linear-gradient(180deg, #14181F 0%, #0D1014 100%);
            border: 1px solid #353C46;
            color: #ECEEF0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            border-radius: 12px;
            overflow: hidden;
        }
        .tp-card::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 32px 32px;
            mask-image: linear-gradient(180deg, black 50%, transparent 100%);
            -webkit-mask-image: linear-gradient(180deg, black 50%, transparent 100%);
            pointer-events: none;
        }
        .tp-inner { position: relative; z-index: 2; padding: 32px 36px; }

        .tp-eyebrow {
            display: inline-flex; align-items: center; gap: 10px;
            font-family: 'IBM Plex Mono', monospace; font-size: 11px;
            letter-spacing: 0.16em; text-transform: uppercase; color: #F2A82A;
        }
        .tp-eyebrow::before { content: ''; width: 14px; height: 1.5px; background: #F2A82A; }

        .tp-card h2 {
            font-family: 'Archivo', system-ui, sans-serif; font-weight: 800;
            font-size: clamp(24px, 2.6vw, 36px);
            line-height: 1.0; letter-spacing: -0.026em;
            margin: 14px 0 0; color: #ECEEF0;
        }
        .tp-card h2 .am { color: #F2A82A; }

        .tp-summary {
            display: grid;
            grid-template-columns: minmax(200px, 1fr) minmax(220px, 1.4fr) minmax(160px, 1fr);
            gap: 0;
            margin-top: 24px;
            border: 1px solid rgba(242,237,226,0.12);
            border-radius: 6px;
            overflow: hidden;
        }
        @media (max-width: 760px) { .tp-summary { grid-template-columns: 1fr; } }
        .tp-summary > div {
            padding: 18px 22px;
            border-right: 1px solid rgba(242,237,226,0.10);
            background: rgba(20,24,31,0.5);
            display: flex; flex-direction: column; gap: 6px;
        }
        .tp-summary > div:last-child { border-right: 0; }
        @media (max-width: 760px) { .tp-summary > div { border-right: 0; border-bottom: 1px solid rgba(242,237,226,0.10); } }
        .tp-summary .l {
            font-family: 'IBM Plex Mono', monospace; font-size: 10.5px;
            letter-spacing: 0.16em; text-transform: uppercase; color: #6B727B;
        }
        .tp-summary .v {
            font-family: 'Archivo', system-ui, sans-serif; font-weight: 800;
            font-size: 32px; letter-spacing: -0.022em; color: #ECEEF0;
            line-height: 1;
        }
        .tp-summary .v .small { font-size: 0.5em; color: #6B727B; margin-left: 6px; font-weight: 500; }
        .tp-delta {
            font-family: 'IBM Plex Mono', monospace; font-size: 11px; font-weight: 600;
            letter-spacing: 0.06em;
        }
        .tp-delta.up { color: #4ADE80; }
        .tp-delta.flat { color: #6B727B; }
        .tp-delta.down { color: #F2A82A; }

        .tp-chartcell { padding: 14px 18px !important; gap: 4px !important; }
        .tp-chartcell svg { width: 100%; height: 60px; display: block; }

        /* Top pages list */
        .tp-list {
            margin-top: 24px;
            border: 1px solid rgba(242,237,226,0.10);
            border-radius: 6px;
            overflow: hidden;
        }
        .tp-list .head {
            display: grid; grid-template-columns: 36px 1fr 110px 90px;
            gap: 16px; padding: 12px 18px;
            background: rgba(7,9,12,0.55);
            border-bottom: 1px solid rgba(242,237,226,0.10);
            font-family: 'IBM Plex Mono', monospace; font-size: 10.5px;
            letter-spacing: 0.16em; text-transform: uppercase; color: #6B727B;
        }
        .tp-row {
            display: grid; grid-template-columns: 36px 1fr 110px 90px;
            gap: 16px; padding: 14px 18px; align-items: center;
            border-bottom: 1px solid rgba(242,237,226,0.06);
            transition: background .15s;
        }
        .tp-row:last-child { border-bottom: 0; }
        .tp-row:hover { background: rgba(242,168,42,0.04); }
        .tp-rank {
            font-family: 'IBM Plex Mono', monospace; font-size: 11px;
            color: #6B727B; letter-spacing: 0.1em;
        }
        .tp-row.top1 .tp-rank { color: #F2A82A; font-weight: 700; }
        .tp-name { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
        .tp-name .ttl {
            font-family: 'Archivo', system-ui, sans-serif; font-weight: 700;
            font-size: 14.5px; line-height: 1.25;
            color: #ECEEF0; letter-spacing: -0.008em;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .tp-name .pth {
            font-family: 'IBM Plex Mono', monospace; font-size: 10.5px;
            letter-spacing: 0.06em; color: #6B727B;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .tp-name .pth a { color: inherit; text-decoration: none; }
        .tp-name .pth a:hover { color: #F2A82A; }
        .tp-spark { width: 100%; height: 28px; }
        .tp-count {
            font-family: 'Archivo', system-ui, sans-serif; font-weight: 800;
            font-size: 22px; color: #ECEEF0; letter-spacing: -0.02em;
            text-align: right; line-height: 1;
            font-variant-numeric: tabular-nums;
        }
        .tp-count .pct { font-size: 11px; color: #6B727B; font-weight: 500; margin-left: 4px; }

        .tp-empty {
            padding: 40px 20px; text-align: center; color: #6B727B;
            font-family: 'IBM Plex Mono', monospace; font-size: 12px;
            letter-spacing: 0.12em; text-transform: uppercase;
        }
        .tp-empty b { color: #B0B7C0; }
        .tp-foot {
            margin-top: 18px;
            font-family: 'IBM Plex Mono', monospace; font-size: 11px;
            letter-spacing: 0.12em; text-transform: uppercase; color: #6B727B;
            display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px;
        }
        .tp-foot b { color: #B0B7C0; font-weight: 500; }
    </style>

    <div class="tp-card">
        <div class="tp-inner">
            <span class="tp-eyebrow">VISITS · ROLLING 7 DAYS</span>
            <h2>Your top pages this <span class="am">week.</span></h2>

            <div class="tp-summary">
                <div>
                    <span class="l">Visits this week</span>
                    <span class="v">{{ number_format($thisWeek) }}</span>
                    <span class="tp-delta {{ $delta > 5 ? 'up' : ($delta < -5 ? 'down' : 'flat') }}">
                        {{ $deltaArrow }} {{ $deltaSign }}{{ $delta }}% vs. prior 7 days
                    </span>
                </div>

                <div class="tp-chartcell">
                    <span class="l">Daily — last 7 days</span>
                    <svg viewBox="0 0 100 36" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="tpAreaGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#F2A82A" stop-opacity="0.55"/>
                                <stop offset="100%" stop-color="#F2A82A" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        @if($maxDay > 0)
                            <path d="{{ $areaPath }}" fill="url(#tpAreaGrad)"/>
                            <path d="{{ $linePath }}" fill="none" stroke="#F2A82A" stroke-width="1.4" stroke-linejoin="round" stroke-linecap="round"/>
                            @foreach($days as $i => $d)
                                @php
                                    $cx = $days->count() === 1 ? 0 : ($i / ($days->count() - 1)) * $w;
                                    $cy = $h - ($d['count'] / max($maxDay, 1)) * ($h - 4);
                                @endphp
                                <circle cx="{{ round($cx, 2) }}" cy="{{ round($cy, 2) }}" r="0.9" fill="#F2A82A"/>
                            @endforeach
                        @else
                            <line x1="0" y1="{{ $h - 1 }}" x2="{{ $w }}" y2="{{ $h - 1 }}" stroke="#353C46" stroke-width="0.5"/>
                        @endif
                    </svg>
                    <div style="display:flex;justify-content:space-between;font-family:'IBM Plex Mono',monospace;font-size:9.5px;color:#6B727B;letter-spacing:0.1em;margin-top:4px;">
                        <span>{{ $days->first()['label'] ?? '' }}</span>
                        <span>{{ $days->last()['label'] ?? '' }}</span>
                    </div>
                </div>

                <div>
                    <span class="l">All-time visits</span>
                    <span class="v">{{ number_format($totalEver) }}</span>
                    <span class="tp-delta flat">+{{ number_format($bots) }} bot hits filtered (7d)</span>
                </div>
            </div>

            <div class="tp-list">
                <div class="head">
                    <span>#</span>
                    <span>Page</span>
                    <span>Daily 7d</span>
                    <span style="text-align:right;">Visits</span>
                </div>
                @forelse($top as $i => $row)
                    @php
                        $maxSpark = max(max($row->spark), 1);
                        $sw = 100; $sh = 28;
                        $sp = [];
                        $bars = [];
                        foreach ($row->spark as $j => $v) {
                            $cnt = max(count($row->spark), 1);
                            $x = $cnt === 1 ? 0 : ($j / ($cnt - 1)) * $sw;
                            $y = $sh - ($v / $maxSpark) * ($sh - 4);
                            $sp[] = round($x, 2) . ',' . round($y, 2);
                            $barW = $sw / $cnt;
                            $barH = ($v / $maxSpark) * ($sh - 4);
                            $bars[] = sprintf('<rect x="%.2f" y="%.2f" width="%.2f" height="%.2f" fill="rgba(242,168,42,%.2f)" />',
                                $j * $barW + 1, $sh - $barH, $barW - 2, $barH, 0.4 + 0.5 * ($v / $maxSpark));
                        }
                        $sparkPath = 'M ' . implode(' L ', $sp);
                        $rowPct = round(($row->count / max($thisWeek, 1)) * 100);
                    @endphp
                    <a class="tp-row {{ $i === 0 ? 'top1' : '' }}" href="{{ url($row->path) }}" target="_blank" rel="noopener">
                        <span class="tp-rank">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="tp-name">
                            <span class="ttl">{{ $row->title }}</span>
                            <span class="pth">{{ $row->path }}</span>
                        </div>
                        <svg class="tp-spark" viewBox="0 0 {{ $sw }} {{ $sh }}" preserveAspectRatio="none">
                            {!! implode('', $bars) !!}
                        </svg>
                        <span class="tp-count">{{ number_format($row->count) }}<span class="pct">·{{ $rowPct }}%</span></span>
                    </a>
                @empty
                    <div class="tp-empty">
                        <b>No visits recorded yet.</b><br/>
                        <span style="opacity:0.7">Open <a href="{{ url('/') }}" target="_blank" style="color:#F2A82A;">brownclawam.ca</a> in another tab — visits will appear here within a minute.</span>
                    </div>
                @endforelse
            </div>

            <div class="tp-foot">
                <span><b>Local analytics</b> · self-hosted, IPs hashed, bots filtered</span>
                <span>Refresh window: <b>last 7 days</b> · prior baseline: <b>days 8–14</b></span>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
