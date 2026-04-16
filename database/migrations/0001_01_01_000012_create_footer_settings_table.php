<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_url')->nullable();
            $table->text('description')->nullable();
            $table->text('services_list')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('quick_link1_label')->nullable();
            $table->string('quick_link1_url')->nullable();
            $table->string('quick_link2_label')->nullable();
            $table->string('quick_link2_url')->nullable();
            $table->string('quick_link3_label')->nullable();
            $table->string('quick_link3_url')->nullable();
            $table->text('newsletter_text')->nullable();
            $table->string('newsletter_button_label')->nullable();
            $table->string('privacy_url')->nullable();
            $table->string('terms_url')->nullable();
            $table->string('copyright_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
