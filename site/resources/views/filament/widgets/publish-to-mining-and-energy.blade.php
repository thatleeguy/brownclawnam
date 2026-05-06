@php
    use App\Filament\Resources\Insights\InsightResource;
    /** @var int $publishedCount */
    /** @var int $syndicatedCount */
    /** @var int $unsyndicatedCount */
    /** @var \Illuminate\Support\Collection $unsyndicated */
    /** @var \App\Models\Insight|null $latestSyndicated */
@endphp

<x-filament-widgets::widget>
    <style>
        .me-card {
            position: relative;
            background: linear-gradient(180deg, #14181F 0%, #0D1014 100%);
            border: 1px solid #353C46;
            color: #ECEEF0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            border-radius: 12px;
            overflow: hidden;
        }
        .me-card::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 92% 0%, rgba(242,168,42,0.18), transparent 55%),
                radial-gradient(ellipse at 0% 100%, rgba(242,168,42,0.06), transparent 50%);
            pointer-events: none;
        }
        .me-card::after {
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
        .me-card .me-inner { position: relative; z-index: 2; padding: 32px 36px; }

        .me-eyebrow {
            display: inline-flex; align-items: center; gap: 10px;
            font-family: 'IBM Plex Mono', monospace; font-size: 11px;
            letter-spacing: 0.16em; text-transform: uppercase; color: #F2A82A;
        }
        .me-eyebrow::before { content: ''; width: 14px; height: 1.5px; background: #F2A82A; }
        .me-eyebrow .pill {
            margin-left: 4px; padding: 2px 8px; background: #F2A82A; color: #07090C;
            border-radius: 999px; font-weight: 700; letter-spacing: 0.08em; font-size: 10px;
        }

        .me-card h2 {
            font-family: 'Archivo', system-ui, sans-serif; font-weight: 800;
            font-size: clamp(28px, 3.2vw, 44px);
            line-height: 1.0; letter-spacing: -0.028em;
            margin: 14px 0 0; max-width: 22ch; color: #ECEEF0;
        }
        .me-card h2 .am { color: #F2A82A; }
        .me-card .me-lede {
            margin-top: 14px; max-width: 64ch;
            color: #B0B7C0; font-size: 15px; line-height: 1.55;
        }
        .me-card .me-lede b { color: #ECEEF0; font-weight: 600; }

        .me-stats {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 0;
            margin-top: 28px;
            border: 1px solid rgba(242,237,226,0.12);
            border-radius: 6px; overflow: hidden;
        }
        @media (max-width: 720px) { .me-stats { grid-template-columns: 1fr; } }
        .me-stat {
            padding: 18px 20px; border-right: 1px solid rgba(242,237,226,0.10);
            display: flex; flex-direction: column; gap: 4px;
            background: rgba(20,24,31,0.5);
        }
        .me-stat:last-child { border-right: 0; }
        @media (max-width: 720px) { .me-stat { border-right: 0; border-bottom: 1px solid rgba(242,237,226,0.10); } }
        .me-stat .l {
            font-family: 'IBM Plex Mono', monospace; font-size: 10.5px;
            letter-spacing: 0.16em; text-transform: uppercase; color: #6B727B;
        }
        .me-stat .v {
            font-family: 'Archivo', system-ui, sans-serif; font-weight: 800;
            font-size: 28px; letter-spacing: -0.02em; color: #ECEEF0;
        }
        .me-stat .v .am { color: #F2A82A; }
        .me-stat .ctx { font-size: 12px; color: #6B727B; }

        .me-actions {
            display: flex; flex-wrap: wrap; gap: 10px; margin-top: 28px;
        }
        .me-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 12px 18px; font-family: 'IBM Plex Mono', monospace;
            font-size: 11px; font-weight: 700; letter-spacing: 0.14em;
            text-transform: uppercase; border: 1px solid;
            transition: background .2s, color .2s, transform .2s;
            cursor: pointer; text-decoration: none;
        }
        .me-btn-amber { background: #F2A82A; color: #07090C; border-color: #F2A82A; }
        .me-btn-amber:hover { background: #FFB937; }
        .me-btn-ghost { background: transparent; color: #ECEEF0; border-color: #4A525E; }
        .me-btn-ghost:hover { background: rgba(255,255,255,0.04); border-color: #6B727B; }

        .me-pipe {
            margin-top: 28px;
            border: 1px solid rgba(242,237,226,0.10);
            border-radius: 6px;
            overflow: hidden;
        }
        .me-pipe .pipe-head {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 18px;
            background: rgba(7,9,12,0.5);
            border-bottom: 1px solid rgba(242,237,226,0.10);
            font-family: 'IBM Plex Mono', monospace; font-size: 10.5px;
            letter-spacing: 0.16em; text-transform: uppercase; color: #B0B7C0;
        }
        .me-pipe .pipe-head b { color: #F2A82A; }
        .me-row {
            display: grid; grid-template-columns: 1fr auto;
            gap: 14px; padding: 14px 18px; align-items: center;
            border-bottom: 1px solid rgba(242,237,226,0.06);
            text-decoration: none;
            transition: background .15s;
        }
        .me-row:hover { background: rgba(242,168,42,0.04); }
        .me-row:last-child { border-bottom: 0; }
        .me-row .meta {
            display: flex; gap: 12px;
            font-family: 'IBM Plex Mono', monospace; font-size: 10.5px;
            letter-spacing: 0.14em; text-transform: uppercase; color: #6B727B;
            margin-bottom: 4px;
        }
        .me-row .meta b { color: #ECEEF0; font-weight: 500; }
        .me-row .meta .am { color: #F2A82A; }
        .me-row .ttl {
            font-family: 'Archivo', system-ui, sans-serif; font-weight: 700;
            font-size: 16px; line-height: 1.2; color: #ECEEF0; letter-spacing: -0.01em;
        }
        .me-row .arrow {
            font-family: 'IBM Plex Mono', monospace; font-size: 11px;
            color: #F2A82A; letter-spacing: 0.16em; text-transform: uppercase;
            white-space: nowrap;
        }
        .me-empty {
            padding: 24px 18px; text-align: center; color: #6B727B;
            font-family: 'IBM Plex Mono', monospace; font-size: 11px;
            letter-spacing: 0.14em; text-transform: uppercase;
        }

        .me-foot {
            margin-top: 24px; padding-top: 18px;
            border-top: 1px solid rgba(242,237,226,0.10);
            font-size: 12.5px; color: #6B727B; line-height: 1.6;
            max-width: 70ch;
        }
        .me-foot b { color: #B0B7C0; font-weight: 500; }
    </style>

    <div class="me-card">
        <div class="me-inner">
            <span class="me-eyebrow">SYNDICATION CHANNEL <span class="pill">VALUE-ADD</span></span>

            <h2>Publish your content to <span class="am">Mining &amp; Energy.</span></h2>

            <p class="me-lede">
                Each briefing you publish on Brownclaw is a candidate for
                syndication to Mining &amp; Energy. <b>Generate a copy-ready
                packet</b>, send it to the editor, then mark the piece syndicated
                here so the network can see your reach.
            </p>

            <div class="me-stats">
                <div class="me-stat">
                    <span class="l">Briefings published</span>
                    <span class="v">{{ $publishedCount }}</span>
                    <span class="ctx">Live on /briefings</span>
                </div>
                <div class="me-stat">
                    <span class="l">Syndicated to M&amp;E</span>
                    <span class="v">{{ $syndicatedCount }}<span class="am"> /{{ $publishedCount }}</span></span>
                    <span class="ctx">
                        @if($latestSyndicated)
                            Latest: {{ $latestSyndicated->syndicated_at->diffForHumans() }}
                        @else
                            None recorded yet
                        @endif
                    </span>
                </div>
                <div class="me-stat">
                    <span class="l">Awaiting syndication</span>
                    <span class="v {{ $unsyndicatedCount > 0 ? 'am' : '' }}">{{ $unsyndicatedCount }}</span>
                    <span class="ctx">Published, not yet syndicated</span>
                </div>
            </div>

            <div class="me-actions">
                <a href="{{ InsightResource::getUrl('index') }}" class="me-btn me-btn-amber">
                    Pick a briefing →
                </a>
                <a href="{{ InsightResource::getUrl('create') }}" class="me-btn me-btn-ghost">
                    Write a new one
                </a>
            </div>

            @if($unsyndicated->count())
                <div class="me-pipe">
                    <div class="pipe-head">
                        <span>READY TO SYNDICATE <b>· {{ $unsyndicated->count() }} BRIEFING@if($unsyndicated->count() > 1)S@endif</b></span>
                        <span>FROM /BRIEFINGS</span>
                    </div>
                    @foreach($unsyndicated as $brief)
                        <a class="me-row" href="{{ InsightResource::getUrl('edit', ['record' => $brief]) }}">
                            <div>
                                <div class="meta">
                                    <span class="am">{{ $brief->code ?? 'BRIEF / ' . str_pad($brief->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    <span><b>{{ strtoupper($brief->kicker ?? 'BRIEFING') }}</b></span>
                                    <span>{{ optional($brief->published_at)->format('d M y') }}</span>
                                    @if($brief->reading_minutes)
                                        <span>{{ $brief->reading_minutes }} MIN</span>
                                    @endif
                                </div>
                                <div class="ttl">{{ $brief->title }}</div>
                            </div>
                            <span class="arrow">Publish to M&amp;E →</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="me-pipe">
                    <div class="me-empty">All published briefings have been syndicated. Write a new brief to keep the channel warm.</div>
                </div>
            @endif

            <div class="me-foot">
                <b>How this works.</b>
                Open any unsyndicated briefing above and use the
                <b>Publish to M&amp;E</b> action to copy a press-ready bundle
                (title, byline, body, attribution, canonical link). Send it to
                Mining &amp; Energy's editor. When they publish, return here and
                use <b>Mark syndicated to M&amp;E</b> to record the date and the
                published URL.
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
