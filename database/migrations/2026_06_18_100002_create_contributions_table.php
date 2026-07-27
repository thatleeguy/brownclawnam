<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('blurb')->nullable();
            $table->string('image')->nullable();        // uploads disk path
            $table->string('metric_value')->nullable(); // e.g. "$25K", "500+"
            $table->string('metric_label')->nullable(); // e.g. "Raised", "Volunteer hours"
            $table->string('year')->nullable();         // for ordering / future timeline
            $table->string('link')->nullable();         // optional URL to the charity/cause
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
