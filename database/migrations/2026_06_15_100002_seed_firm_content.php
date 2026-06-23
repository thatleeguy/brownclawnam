<?php

use Database\Seeders\FirmContentSeeder;
use Illuminate\Database\Migrations\Migration;

/**
 * Seed the Firm page content singleton on deploy (migrate runs, db:seed does not).
 * Only-if-empty: the seeder skips when a firm_contents row already exists, so it
 * populates the brand-new table on first deploy and never overwrites content.
 */
return new class extends Migration
{
    public function up(): void
    {
        (new FirmContentSeeder())->run();
    }

    public function down(): void
    {
        // Content-only migration; nothing structural to reverse.
    }
};
