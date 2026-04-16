<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->text('organization_name')->nullable()->after('site_name');
            $table->text('organization_description')->nullable()->after('tagline');
            $table->text('vision')->nullable()->after('organization_description');
            $table->text('mission')->nullable()->after('vision');
            $table->string('registration_number')->nullable();
            $table->string('founding_year')->nullable();
            $table->text('about_text')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn([
                'organization_name',
                'organization_description',
                'vision',
                'mission',
                'registration_number',
                'founding_year',
                'about_text',
                'bank_name',
                'bank_account',
                'bank_account_name',
                'primary_phone',
                'secondary_phone',
                'primary_email',
                'facebook_url',
                'twitter_url',
                'instagram_url',
                'linkedin_url',
            ]);
        });
    }
};
