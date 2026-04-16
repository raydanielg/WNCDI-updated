<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('security_settings', function (Blueprint $table) {
            $table->boolean('system_enabled')->default(true)->after('two_factor_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('security_settings', function (Blueprint $table) {
            $table->dropColumn('system_enabled');
        });
    }
};
