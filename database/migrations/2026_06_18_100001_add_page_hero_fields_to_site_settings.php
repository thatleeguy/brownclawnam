<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Contact page hero
            $table->string('contact_hero_eyebrow')->nullable();
            $table->text('contact_hero_headline_html')->nullable();
            $table->text('contact_hero_sub')->nullable();

            // Capabilities index page hero
            $table->string('capabilities_hero_eyebrow')->nullable();
            $table->text('capabilities_hero_headline_html')->nullable();
            $table->text('capabilities_hero_sub')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'contact_hero_eyebrow', 'contact_hero_headline_html', 'contact_hero_sub',
                'capabilities_hero_eyebrow', 'capabilities_hero_headline_html', 'capabilities_hero_sub',
            ]);
        });
    }
};
