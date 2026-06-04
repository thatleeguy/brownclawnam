<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * @param bool $force  When false (default, e.g. db:seed), skip if the row
     *                     already exists so admin edits are never overwritten.
     *                     The one-time round-2 migration passes true.
     */
    public function run(bool $force = false): void
    {
        if (! $force && SiteSetting::whereKey(1)->exists()) {
            return;
        }

        SiteSetting::updateOrCreate(['id' => 1], [
            // ----- BRAND -----
            'brand_name'    => 'Brownclaw Asset Management',
            'brand_tagline' => null,
            'logo_path'     => 'img/logo-side.png',
            'favicon_path'  => 'favicon.png',

            'default_meta_title'       => 'Brownclaw Asset Management — Reliability Engineering for Heavy Industry',
            'default_meta_description' => 'A reliability and asset-management practice for mining and energy operators.',

            // ----- NAVIGATION -----
            'nav_items' => [
                ['number' => '01', 'label' => 'CAPABILITIES', 'url' => '/capabilities', 'visible' => true],
                ['number' => '02', 'label' => 'EVIDENCE',     'url' => '/#evidence',    'visible' => true],
                ['number' => '03', 'label' => 'WORK',         'url' => '/work',         'visible' => true],
                ['number' => '04', 'label' => 'BRIEFINGS',    'url' => '/briefings',    'visible' => true],
                ['number' => '05', 'label' => 'FIRM',         'url' => '/firm',         'visible' => true],
            ],
            'nav_cta_label' => 'REQUEST ENGAGEMENT',
            'nav_cta_url'   => '/contact',

            // ----- FOOTER ----- (:year is replaced with the current year at render)
            'footer_lines' => [
                ['text' => '<b>BROWNCLAW ASSET MANAGEMENT</b> &nbsp;·&nbsp; FERNIE BC'],
                ['text' => 'EST. 2025'],
                ['text' => '© :year BROWNCLAW ASSET MANAGEMENT INC.'],
            ],

            // ----- STATUS BAR ----- (hidden per client; values kept for if re-enabled)
            'statusbar_visible'      => false,
            'statusbar_status_label' => 'Practice',
            'statusbar_status_value' => 'online',
            'statusbar_location'     => 'Fernie BC',
            'statusbar_availability' => null,
            'statusbar_creds'        => null,

            // ----- CONTACT CTA BAND -----
            'cta_visible'       => true,
            'cta_eyebrow'       => 'REQUEST · ENGAGEMENT INTAKE',
            'cta_headline_html' => 'If your reliability program isn\'t aging well, <span class="am">let\'s talk.</span>',
            'cta_lede'          => 'First conversations are free and structured. Thirty minutes is usually enough to know whether we\'re a good fit for one another. Bring your maintenance challenges, and we\'ll bring the right questions.',
            'cta_button_label'  => 'LET\'S TALK',

            // ----- CONTACT CARD -----
            'contact_email'         => 'info@brownclawam.ca',
            'contact_email_note'    => 'Replies inside 24 hrs, Mon–Fri.',
            'contact_phone_display' => '+1 (866) 258-6572',
            'contact_phone_url'     => '+18662586572',
            'contact_phone_note'    => 'Pacific time. Voicemail forwards to email.',
            'contact_location'      => 'Fernie, British Columbia',
            'contact_location_note' => 'Working on-site across Western Canada and the Rocky Mountain corridor.',

            // ----- PRINCIPAL ----- (deprecated: bios now managed via Team members)
            'principal_visible' => false,
        ]);
    }
}
