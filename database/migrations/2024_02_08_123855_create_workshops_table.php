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
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('conference_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('venue')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('time')->nullable();
            $table->string('chair_person_name')->nullable();
            $table->string('chair_person_affiliation')->nullable();
            $table->string('chair_person_image')->nullable();
            $table->string('chair_person_cv')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('cpd_point')->nullable();
            $table->integer('no_of_participants')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->string('estimated_budget')->nullable();
            $table->date('registration_deadline')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_applied')->default(0);
            $table->tinyInteger('approved_status')->default(1);
            $table->longText('remarks')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};
