<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // On SQLite, altering a column uses a temporary table named "__temp__forum_registrations".
        // If a previous attempt failed, that temp table may still exist and cause this migration to fail.
        // Ensure it is dropped before running the schema change.
        if (config('database.default') === 'sqlite') {
            DB::statement('DROP TABLE IF EXISTS "__temp__forum_registrations"');
        }

        // Ensure there are no NULL values in sponsorship_package before enforcing NOT NULL
        // during the SQLite temp-table copy operation.
        DB::table('forum_registrations')
            ->whereNull('sponsorship_package')
            ->update(['sponsorship_package' => '']);

        Schema::table('forum_registrations', function (Blueprint $table) {
            // Allow long sponsorship package descriptions from legacy WordPress form
            $table->text('sponsorship_package')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_registrations', function (Blueprint $table) {
            // Revert back to string if needed (default length)
            $table->string('sponsorship_package')->change();
        });
    }
};
