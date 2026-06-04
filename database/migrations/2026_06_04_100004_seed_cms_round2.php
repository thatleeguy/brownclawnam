<?php

use Database\Seeders\HomeContentSeeder;
use Database\Seeders\SiteSettingSeeder;
use Database\Seeders\TeamMemberSeeder;
use Illuminate\Database\Migrations\Migration;

/**
 * Populate the CMS with the round-1 / round-2 content values so the changes are
 * reflected live on the server immediately (deploy runs `migrate`, which won't
 * re-run db:seed).
 *
 * This runs ONCE (migrations are tracked), and passes force=true so it applies
 * the values to the existing singleton rows on this deploy. Future deploys do
 * not re-run it, and the seeders default to safe (skip-if-exists) mode, so admin
 * edits to the home page / site settings / team are never clobbered afterwards.
 */
return new class extends Migration
{
    public function up(): void
    {
        (new SiteSettingSeeder())->run(force: true);
        (new HomeContentSeeder())->run(force: true);
        (new TeamMemberSeeder())->run(force: true);
    }

    public function down(): void
    {
        // Content-only migration; nothing structural to reverse.
    }
};
