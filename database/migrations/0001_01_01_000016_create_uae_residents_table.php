<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('uae_residents', function (Blueprint $table) {
            $table->id();
            $table->string('attendee_type')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number');
            $table->string('emirates_id');
            $table->string('job_title')->nullable();
            $table->string('organization')->nullable();
            $table->string('website')->nullable();
            $table->json('attendance_days')->nullable();
            $table->string('package')->nullable();
            $table->boolean('agree_terms')->default(false);
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->unique(['email', 'passport_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uae_residents');
    }
};
