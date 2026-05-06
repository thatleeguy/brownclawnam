<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('path', 512);
            $table->string('route_name', 120)->nullable();
            $table->string('referer', 1024)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->char('ip_hash', 64)->nullable();
            $table->boolean('is_bot')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['path', 'created_at']);
            $table->index(['is_bot', 'created_at']);
            $table->index('route_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
