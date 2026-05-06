<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();

            // Hero
            $table->string('hero_eyebrow')->nullable();
            $table->text('hero_headline_html')->nullable();
            $table->text('hero_sub')->nullable();
            $table->string('hero_primary_cta_label')->nullable();
            $table->string('hero_secondary_cta_label')->nullable();
            $table->json('spec_row')->nullable();

            // Position
            $table->json('position_paragraphs')->nullable();
            $table->string('position_signature_name')->nullable();
            $table->string('position_signature_note')->nullable();

            // Evidence
            $table->string('evidence_kicker')->nullable();
            $table->text('evidence_headline_html')->nullable();
            $table->text('evidence_meta')->nullable();
            $table->json('kpi_metrics')->nullable();

            // Criticality
            $table->string('criticality_eyebrow')->nullable();
            $table->text('criticality_headline_html')->nullable();
            $table->text('criticality_lede_html')->nullable();
            $table->json('criticality_checks')->nullable();
            $table->json('criticality_register')->nullable();

            // Briefings section head
            $table->string('briefings_kicker')->nullable();
            $table->text('briefings_headline_html')->nullable();
            $table->text('briefings_meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};
