<?php

namespace Database\Seeders;

use App\Models\HomeContent;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    /**
     * @param bool $force  When false (default, e.g. db:seed), skip if the row
     *                     already exists so admin edits are never overwritten.
     *                     The one-time round-2 migration passes true.
     */
    public function run(bool $force = false): void
    {
        if (! $force && HomeContent::whereKey(1)->exists()) {
            return;
        }

        HomeContent::updateOrCreate(['id' => 1], [
            // ----- HERO -----
            'hero_eyebrow' => 'Reliability Engineering · Asset Strategy · Mining & Energy',
            'hero_headline_html' => 'We engineer <span class="kw">uptime</span><br/>'
                . 'on the iron <span class="am">that</span><br/>'
                . '<span class="am">moves the rock.</span>',
            'hero_sub' => 'Brownclaw is an independent reliability and asset-management practice for mining and energy operators. We turn reactive maintenance organizations into proactive ones — through structured failure analysis, defensible asset strategy, and on-the-ground execution with the people doing the work.',
            'hero_primary_cta_label' => 'Request engagement',
            'hero_secondary_cta_label' => 'Recent work',
            'hero_image' => 'img/site-hero.jpg',
            'hero_captions' => [
                'doc_label'  => '<b>SITE / 047</b> &nbsp;·&nbsp; SURFACE MINE &nbsp;·&nbsp; HAUL ROAD',
                'doc_ref'    => 'DOC · 03 / 2026',
                'tag1_title' => 'HAUL FLEET',
                'tag1_sub'   => 'ULTRA-CLASS TRUCK · LOADED',
                'tag2_title' => 'HAUL CYCLE',
                'tag2_sub'   => 'ROM ORE · PIT TO CRUSHER',
                'foot_left'  => '<b>WESTERN CANADA</b> · ENGAGEMENT ARCHIVE',
                'foot_right' => '2025',
            ],
            'spec_row' => [
                ['label' => 'Sectors',       'value' => 'Mining', 'unit' => '·Energy'],
                ['label' => 'Practice yrs',  'value' => '9',      'unit' => '+'],
                ['label' => 'Sites worked',  'value' => '17',     'unit' => '+'],
            ],

            // ----- COMMODITY RIBBON -----
            'ribbon_label' => 'SECTOR EXPERIENCE / COMMODITY',
            'commodities' => [
                ['name' => 'METALLURGICAL COAL', 'active' => true],
                ['name' => 'DIAMOND',            'active' => true],
                ['name' => 'GOLD',               'active' => true],
                ['name' => 'COPPER',             'active' => true],
                ['name' => 'ZINC',               'active' => true],
                ['name' => 'NUCLEAR',            'active' => true],
                ['name' => 'URANIUM',            'active' => true],
            ],

            // ----- POSITION -----
            'position_heading' => 'What drives us',
            'position_paragraphs' => [
                'Equipment doesn\'t fail at random. It fails for reasons — <b>and the reasons are usually upstream of the work order.</b>',
                'Most operations don\'t have a maintenance problem. They have a <span class="am">decision problem</span>: too many priorities, not enough criticality, and a CMMS that records <span class="strike">causes</span> symptoms.',
                'Brownclaw is built around one premise: reliability is engineered, not hoped for. We bring the methods — RCFA, FMEA, RCM, criticality, Weibull — and we bring them <b>onto your floor</b>, with the people doing the work, until the program is yours, not ours.',
            ],
            'position_signature_name' => 'Connor Schriver · Founder',
            'position_signature_note' => 'SIG / 2026.04 / FERNIE BC',

            // ----- SECTION VISIBILITY ----- (hidden per client until content is ready)
            'practice_visible'       => false,
            'practice_headline_html' => 'Three capabilities. <span class="am">One discipline.</span>',
            'criticality_visible'    => false,
            'briefings_visible'      => false,
            'work_visible'           => false,

            // ----- EVIDENCE -----
            'evidence_kicker' => 'RESULTS / SELECTED ENGAGEMENTS',
            'evidence_headline_html' => 'Reliability is judged by what stays <span class="am">running.</span>',
            'evidence_meta' => 'Indicative figures from the last 36 months. All data drawn from operator-side CMMS / historian extracts at engagement start and engagement close. References available on request.',
            'kpi_metrics' => [
                [
                    'name' => 'UNPLANNED DOWNTIME',
                    'source' => '▼ Δ vs. baseline',
                    'value_display' => '−62',
                    'unit' => '%',
                    'delta_caption' => '9-mo. PM optimization · coal prep',
                    'description' => 'From 14.8% → 5.6% on the prep plant after FMEA-driven tactic rewrite.',
                    'context' => 'Metallurgical coal',
                ],
                [
                    'name' => 'RECURRING SAVINGS',
                    'source' => '▼ annualised',
                    'value_display' => '4.2',
                    'unit' => 'M',
                    'unit_prefix' => '$',
                    'delta_caption' => 'PM rationalization · open-pit fleet',
                    'description' => '38% of work-orders retired or re-scoped after criticality reset.',
                    'context' => 'Open-pit mining',
                ],
                [
                    'name' => 'MTBF · BAD ACTORS',
                    'source' => '▲ Δ vs. baseline',
                    'value_display' => '8.5',
                    'unit' => '×',
                    'delta_caption' => 'RCFA-driven redesign · top-10 list',
                    'description' => 'Mean time between failure on top-10 bad actors after redesign.',
                    'context' => 'Concentrator',
                ],
                [
                    'name' => 'ASSET AVAILABILITY',
                    'source' => '▲ sustained 12 mo.',
                    'value_display' => '94.7',
                    'unit' => '%',
                    'delta_caption' => 'Up from 81% on critical line',
                    'description' => 'Sustained 12-month availability on a primary crusher line.',
                    'context' => 'Crusher',
                ],
            ],

            // ----- CRITICALITY -----
            'criticality_eyebrow' => 'METHOD / CRITICALITY',
            'criticality_headline_html' => 'Where to spend the next reliability dollar — and where <span class="am">not to.</span>',
            'criticality_lede_html' => 'Every site has a budget, and every budget has a fight. We rank equipment criticality across <b style="color:var(--txt)">consequence</b> (safety, environmental, production loss, repair cost) against <b style="color:var(--txt)">probability</b> (failure history, age, duty), and we hand back a defensible, signable register that survives audit and turnover.',
            'criticality_checks' => [
                'Asset hierarchy reset to <b>functional</b> level (not nameplate)',
                'Criticality scored against <b>your</b> risk matrix, not a generic one',
                'Each tactic <b>traced to a failure mode</b>, not a vendor recommendation',
                'Spares strategy reviewed against the new criticality call',
            ],
            'criticality_register' => [
                ['tag' => 'CRH-01',  'equipment' => 'Primary gyratory crusher',     'level' => 'h', 'hours' => '+712', 'score' => 95],
                ['tag' => 'CONV-04', 'equipment' => 'Overland conveyor 04',         'level' => 'h', 'hours' => '+708', 'score' => 80],
                ['tag' => 'SAG-01',  'equipment' => 'SAG mill (drive train)',       'level' => 'h', 'hours' => '+704', 'score' => 80],
                ['tag' => 'CYC-04',  'equipment' => 'Hydrocyclone bank · A2',       'level' => 'm', 'hours' => '+612', 'score' => 60],
                ['tag' => 'PMP-12',  'equipment' => 'Slurry pump · froth feed',     'level' => 'm', 'hours' => '+540', 'score' => 60],
                ['tag' => 'FAN-03',  'equipment' => 'Vent fan · concentrate dryer', 'level' => 'l', 'hours' => '+360', 'score' => 40],
                ['tag' => 'COMP-08', 'equipment' => 'Air compressor · backup',      'level' => 'l', 'hours' => '+180', 'score' => 25],
            ],

            // ----- BRIEFINGS HEAD -----
            'briefings_kicker' => 'WRITING / FIELD BRIEFINGS',
            'briefings_headline_html' => 'Field briefings. <span class="am">Plain-spoken.</span>',
            'briefings_meta' => 'A rolling collection of technical memoranda, methods notes, and lessons-from-the-floor. Written for the people doing the work — free of the usual consulting jargon.',
        ]);
    }
}
