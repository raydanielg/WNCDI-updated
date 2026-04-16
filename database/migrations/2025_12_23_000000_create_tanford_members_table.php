<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tanford_members', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->date('date')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_or_id')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('company_name')->nullable();
            $table->string('country_of_registration')->nullable();
            $table->string('business_location')->nullable();
            $table->json('services')->nullable();
            $table->string('other_services')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('tin')->nullable();
            $table->boolean('willing_to_join')->default(false);
            $table->text('reason')->nullable();
            $table->boolean('agree_terms')->default(false);
            $table->string('signature_name')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanford_members');
    }
};
