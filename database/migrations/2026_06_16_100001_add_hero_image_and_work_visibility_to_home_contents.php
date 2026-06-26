<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            // Uploadable hero image (path under /public; blank = default img/site-hero.jpg)
            $table->string('hero_image')->nullable()->after('hero_sub');

            // Show/hide the "Evidence, not endorsements" work section.
            // Defaults false so it is hidden on deploy per client request, without
            // a data migration touching any existing content.
            $table->boolean('work_visible')->default(false)->after('kpi_metrics');
        });
    }

    public function down(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->dropColumn(['hero_image', 'work_visible']);
        });
    }
};
