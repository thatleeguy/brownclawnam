<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();

            // Card
            $table->string('name');                          // CONNOR SCHRIVER
            $table->string('title')->nullable();             // Founder · Reliability Engineer
            $table->string('creds')->nullable();             // FERNIE BC (use / for stacked lines)
            $table->string('photo')->nullable();             // path under /public, e.g. img/connor.jpg
            $table->string('badge_label')->nullable();       // FOUNDER / TEAM (card header)
            $table->string('file_label')->nullable();        // FILE 005
            $table->string('frame_label')->nullable();       // FRAME 01

            // Body
            $table->string('eyebrow')->nullable();           // FILE 005 · ABOUT THE FIRM
            $table->text('headline_html')->nullable();
            $table->text('bio_html')->nullable();
            $table->json('cv')->nullable();                  // [{label, value}]
            $table->text('quote')->nullable();               // optional pull quote
            $table->string('quote_sign')->nullable();

            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('visible')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
