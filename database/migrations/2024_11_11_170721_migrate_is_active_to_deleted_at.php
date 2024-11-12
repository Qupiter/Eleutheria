<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Set 'deleted_at' for users where 'is_active' is false (deactivated users)
        DB::table('users')
            ->where('is_active', false)
            ->update(['deleted_at' => now()]);

        // Optionally, remove the 'is_active' column if it's no longer needed
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }

    public function down(): void
    {
        // Rollback the data migration
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });

        // Set 'is_active' back based on 'deleted_at' column
        DB::table('users')
            ->whereNotNull('deleted_at')
            ->update(['is_active' => false]);
    }
};
