<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('badge_label')->nullable();
            $table->string('title_line1')->nullable();
            $table->string('title_line2')->nullable();
            $table->text('intro_text')->nullable();
            $table->string('bullet1')->nullable();
            $table->string('bullet2')->nullable();
            $table->string('bullet3')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('left_image_url')->nullable();
            $table->string('right_image_url')->nullable();
            $table->string('experience_label')->nullable();
            $table->string('experience_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_blocks');
    }
};
