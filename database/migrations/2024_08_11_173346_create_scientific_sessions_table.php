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
        Schema::create('scientific_sessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('conference_id')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('topic')->nullable();
            $table->string('hall_id')->nullable();
            $table->string('chairperson')->nullable();
            $table->string('co_chairperson')->nullable();
            $table->string('participants')->nullable();
            $table->string('time')->nullable();
            $table->string('day')->nullable();
            $table->string('duration')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scientific_sessions');
    }
};
