<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $email = 'connor@brownclawam.ca';
        $password = Hash::make('futureBC2026!@#');
        $now = now();

        $exists = DB::table('users')->where('email', $email)->exists();

        if ($exists) {
            DB::table('users')
                ->where('email', $email)
                ->update([
                    'password' => $password,
                    'updated_at' => $now,
                ]);

            return;
        }

        DB::table('users')->insert([
            'name' => 'Connor',
            'email' => $email,
            'email_verified_at' => $now,
            'password' => $password,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        // No-op: do not delete the admin user on rollback.
    }
};
