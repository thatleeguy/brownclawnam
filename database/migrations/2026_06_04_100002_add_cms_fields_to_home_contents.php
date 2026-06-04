<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            // Hero commodity ribbon
            $table->string('ribbon_label')->nullable()->after('spec_row');
            $table->json('commodities')->nullable()->after('ribbon_label');   // [{name, active}]

            // Position section heading (was hardcoded "Why this firm exists")
            $table->string('position_heading')->nullable()->after('position_paragraphs');

            // Section visibility toggles + practice headline
            $table->boolean('practice_visible')->default(true)->after('position_signature_note');
            $table->text('practice_headline_html')->nullable()->after('practice_visible');
            $table->boolean('criticality_visible')->default(true)->after('criticality_register');
            $table->boolean('briefings_visible')->default(true)->after('briefings_meta');
        });
    }

    public function down(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->dropColumn([
                'ribbon_label',
                'commodities',
                'position_heading',
                'practice_visible',
                'practice_headline_html',
                'criticality_visible',
                'briefings_visible',
            ]);
        });
    }
};
