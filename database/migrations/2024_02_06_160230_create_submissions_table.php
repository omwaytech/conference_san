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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('conference_id')->nullable();
            $table->bigInteger('expert_id')->nullable();
            $table->string('topic')->nullable();
            $table->tinyInteger('presentation_type')->nullable();
            $table->longText('cover_letter')->nullable();
            $table->string('presentation_file')->nullable();
            $table->boolean('forward_expert')->default(0);
            $table->tinyInteger('request_status')->default(0);
            $table->string('keywords')->nullable();
            $table->longText('abstract_content')->nullable();
            $table->string('submitted_date')->nullable();
            $table->string('accepted_date')->nullable();
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
        Schema::dropIfExists('submissions');
    }
};
