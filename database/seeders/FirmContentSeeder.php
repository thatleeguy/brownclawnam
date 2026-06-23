<?php

namespace Database\Seeders;

use App\Models\FirmContent;
use Illuminate\Database\Seeder;

class FirmContentSeeder extends Seeder
{
    /**
     * @param bool $force  When false (default, e.g. db:seed), skip if the row
     *                     already exists so admin edits are never overwritten.
     *                     The one-time data migration passes true.
     */
    public function run(bool $force = false): void
    {
        if (! $force && FirmContent::whereKey(1)->exists()) {
            return;
        }

        FirmContent::updateOrCreate(['id' => 1], [
            'meta_description'   => 'Brownclaw Asset Management — nine years in mining and energy reliability across coal, diamond, gold, copper, and zinc.',
            'hero_eyebrow'       => 'THE FIRM',
            'hero_headline_html' => 'A small firm. <span class="am">Tier-1 work.</span>',
            'hero_sub'           => 'Brownclaw is a growing reliability and asset-management practice. Our '
                . 'engagement archive runs across tier-1 metallurgical coal preparation, sub-arctic diamond '
                . 'fleet programs, copper concentrators, and zinc smelters — and we\'re scaling the team to '
                . 'match the work that\'s coming in. Every engagement is led by an engineer on the floor, '
                . 'deliverables ship without a partner-stamp layer, and we hire engineers against the '
                . 'engagements they\'ll lead — never to fill a staffing matrix.',
            'engagement_heading' => 'How an engagement runs',
            'engagement_steps'   => [
                ['number' => '01', 'title' => 'Discovery (no-cost)', 'body' => 'Thirty-minute structured call. Bring the worst bad-actor on your floor; we identify whether reliability practice is the right tool. If it isn\'t, we say so.'],
                ['number' => '02', 'title' => 'Scoping memorandum', 'body' => 'A two-page brief: assumptions, deliverables, phases, fee, what we need from your team. No hidden retainers.'],
                ['number' => '03', 'title' => 'Phase 1 — Establish baseline', 'body' => 'CMMS extract, asset hierarchy review, criticality reset, bad-actor list. Two to four weeks.'],
                ['number' => '04', 'title' => 'Phase 2 — Tactic library + pilot', 'body' => 'Failure-mode-traced tactics on top-criticality assets, written in your CMMS. Operator training in-place.'],
                ['number' => '05', 'title' => 'Phase 3 — Hand-off', 'body' => 'Methods documented, your team trained on the workflow, KPI dashboard installed. We leave when your program runs without us.'],
            ],
        ]);
    }
}
