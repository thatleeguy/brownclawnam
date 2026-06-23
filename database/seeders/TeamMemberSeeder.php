<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * @param bool $force  When false (default, e.g. db:seed), skip if any team
     *                     members already exist so admin edits/additions are
     *                     never overwritten. The one-time round-2 migration passes true.
     */
    public function run(bool $force = false): void
    {
        if (! $force && TeamMember::exists()) {
            return;
        }

        TeamMember::updateOrCreate(['name' => 'CONNOR SCHRIVER'], [
            'title'         => 'Founder · Reliability Engineer',
            'creds'         => 'FERNIE BC',
            'photo'         => 'img/connor.jpg',
            'badge_label'   => 'FOUNDER',
            'file_label'    => 'FILE 005',
            'frame_label'   => 'FRAME 01',
            'eyebrow'       => 'ABOUT THE FIRM',
            'headline_html' => 'Nine years in reliability, built in <span class="am">Canadian mining.</span>',
            'bio_html'      => 'Connor Schriver is the Founder and Senior Consultant of Brownclaw Asset Management, '
                . 'with on-site experience across remote Arctic operations and throughout Western Canada. '
                . 'A Professional Engineer (P.Eng) and Certified Maintenance &amp; Reliability Professional (CMRP), '
                . 'Connor specializes in reliability engineering, asset strategy development, and data-driven '
                . 'lifecycle decision making across metallurgical coal, diamond, gold, copper, and zinc operations.',
            'cv' => [
                ['label' => 'YEARS',       'value' => '9<span class="am">+</span>'],
                ['label' => 'SECTORS',     'value' => 'Mining<span class="am">·</span>Energy'],
                ['label' => 'CREDENTIALS', 'value' => 'P.Eng<span class="am">·</span>CMRP'],
                ['label' => 'BASED',       'value' => 'Fernie BC'],
            ],
            'quote'         => null,
            'quote_sign'    => null,
            'display_order' => 1,
            'visible'       => true,
        ]);

        TeamMember::updateOrCreate(['name' => 'ROSS VRANA-GODWIN'], [
            'title'         => 'Project Engineer · Continuous Improvement',
            'creds'         => 'VANCOUVER BC',
            'photo'         => 'img/ross.jpg',
            'badge_label'   => 'TEAM',
            'file_label'    => 'FILE 006',
            'frame_label'   => 'FRAME 02',
            'eyebrow'       => 'THE TEAM',
            'headline_html' => 'Bringing new perspective to <span class="am">mining operations.</span>',
            'bio_html'      => 'Ross Vrana-Godwin is an Electrical Engineering EIT and Project Management Professional '
                . 'with experience across manufacturing and industrial environments, including large-scale SAP EAM '
                . 'initiatives. He specializes in continuous improvement and process optimization, helping operations '
                . 'address complex challenges and implement practical, data-driven solutions that improve performance.',
            'cv' => [
                ['label' => 'YEARS',       'value' => '5<span class="am">+</span>'],
                ['label' => 'SECTORS',     'value' => 'Manufacturing<span class="am">·</span>Industrial'],
                ['label' => 'CREDENTIALS', 'value' => 'EIT<span class="am">·</span>PMP'],
                ['label' => 'BASED',       'value' => 'Vancouver BC'],
            ],
            'quote'         => null,
            'quote_sign'    => null,
            'display_order' => 2,
            'visible'       => true,
        ]);
    }
}
