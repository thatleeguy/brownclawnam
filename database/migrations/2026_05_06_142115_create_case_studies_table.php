<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sector')->nullable();
            $table->string('sector_label')->nullable();
            $table->string('region')->nullable();
            $table->string('client_display')->nullable();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->json('kpi_stats')->nullable();
            $table->unsignedInteger('engagement_months')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
