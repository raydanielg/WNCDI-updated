<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forum_registrations', function (Blueprint $table) {
            // Column was previously changed to TEXT to support long values.
            // Here we only adjust the nullability to allow NULL values,
            // without shrinking the column size.
            $table->text('sponsorship_package')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_registrations', function (Blueprint $table) {
            // Revert to non-nullable TEXT (matching the previous migration
            // which changed the column to TEXT but not nullable).
            $table->text('sponsorship_package')->nullable(false)->change();
        });
    }
};
