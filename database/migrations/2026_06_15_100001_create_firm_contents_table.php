<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('firm_contents', function (Blueprint $table) {
            $table->id();
            $table->string('meta_description')->nullable();

            // Hero
            $table->string('hero_eyebrow')->nullable();
            $table->text('hero_headline_html')->nullable();
            $table->text('hero_sub')->nullable();

            // "How an engagement runs"
            $table->string('engagement_heading')->nullable();
            $table->json('engagement_steps')->nullable();   // [{number, title, body}]

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('firm_contents');
    }
};
