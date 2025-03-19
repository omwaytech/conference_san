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
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('department')->nullable();
        });

        Schema::table('conference_registrations', function (Blueprint $table) {
            $table->tinyInteger('meal_type')->nullable();
            $table->tinyInteger('has_presented_before')->nullable();
            $table->string('presentation_place')->nullable();
        });

        Schema::table('workshop_registrations', function (Blueprint $table) {
            $table->tinyInteger('meal_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('department');
        });

        Schema::table('conference_registrations', function (Blueprint $table) {
            $table->dropColumn('meal_type');
            $table->dropColumn('has_presented_before');
            $table->dropColumn('presentation_place');
        });

        Schema::table('workshop_registrations', function (Blueprint $table) {
            $table->dropColumn('meal_type');
        });
    }
};
