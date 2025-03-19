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
        Schema::table('submission_settings', function (Blueprint $table) {
            $table->longText('abstract_guidelines')->nullable();
            $table->longText('poster_guidelines')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submission_settings', function (Blueprint $table) {
            $table->dropColumn('abstract_guidelines');
            $table->dropColumn('poster_guidelines');
        });
    }
};
