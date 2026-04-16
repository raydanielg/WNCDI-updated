<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('forum_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('forum_name');
            $table->string('attendee_type')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('organization')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('job_title')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_phone')->nullable();
            $table->unsignedInteger('attendee_count')->nullable();
            $table->json('services')->nullable();
            $table->string('other_services')->nullable();
            $table->json('attendance_days')->nullable();
            $table->string('booth')->nullable();
            $table->string('sponsorship_package')->nullable();
            $table->boolean('agree_terms')->default(false);
            $table->timestamps();

            $table->unique(['forum_name', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_registrations');
    }
};
