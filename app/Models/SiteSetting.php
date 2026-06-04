<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'nav_items'         => 'array',
        'footer_lines'      => 'array',
        'principal_cv'      => 'array',
        'statusbar_visible' => 'boolean',
        'cta_visible'       => 'boolean',
        'principal_visible' => 'boolean',
    ];

    /** Singleton accessor — always returns the row, creating an empty one if missing. */
    public static function current(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }

    /**
     * Navigation items, falling back to the original hardcoded menu when unset.
     *
     * @return array<int, array{number: string, label: string, url: string, visible: bool}>
     */
    public function navItems(): array
    {
        $items = $this->nav_items;

        if (empty($items)) {
            $items = [
                ['number' => '01', 'label' => 'CAPABILITIES', 'url' => '/capabilities', 'visible' => true],
                ['number' => '02', 'label' => 'EVIDENCE',     'url' => '/#evidence',    'visible' => true],
                ['number' => '03', 'label' => 'WORK',         'url' => '/work',         'visible' => true],
                ['number' => '04', 'label' => 'BRIEFINGS',    'url' => '/briefings',    'visible' => true],
                ['number' => '05', 'label' => 'FIRM',         'url' => '/firm',         'visible' => true],
            ];
        }

        return array_values(array_filter($items, fn ($i) => ($i['visible'] ?? true)));
    }

    /** Footer lines, falling back to the original hardcoded footer. */
    public function footerLines(): array
    {
        $lines = collect($this->footer_lines ?? [])
            ->map(fn ($l) => is_array($l) ? ($l['text'] ?? '') : $l)
            ->filter(fn ($l) => filled($l))
            ->values()
            ->all();

        if (! empty($lines)) {
            return $lines;
        }

        $name = $this->brand_name ?: 'BROWNCLAW ASSET MANAGEMENT';

        return [
            "<b>{$name}</b> &nbsp;·&nbsp; FERNIE BC",
            'EST. 2025',
            '© ' . date('Y') . " " . strtoupper($name) . ' INC.',
        ];
    }

    /** Principal CV cells, falling back to the original four. */
    public function principalCv(): array
    {
        $cv = $this->principal_cv;

        if (empty($cv)) {
            return [
                ['label' => 'YEARS',       'value' => '8<span class="am">+</span>'],
                ['label' => 'SECTORS',     'value' => 'Mining<span class="am">·</span>Energy'],
                ['label' => 'CREDENTIALS', 'value' => 'P.Eng<span class="am">·</span>CMRP'],
                ['label' => 'BASED',       'value' => 'Fernie BC'],
            ];
        }

        return $cv;
    }
}
