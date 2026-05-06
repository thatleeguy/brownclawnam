<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->timestamp('syndicated_at')->nullable()->after('published_at');
            $table->string('syndication_url')->nullable()->after('syndicated_at');
            $table->text('syndication_notes')->nullable()->after('syndication_url');
        });
    }

    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn(['syndicated_at', 'syndication_url', 'syndication_notes']);
        });
    }
};
