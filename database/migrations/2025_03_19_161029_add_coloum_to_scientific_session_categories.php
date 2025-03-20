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
        Schema::table('scientific_session_categories', function (Blueprint $table) {
            $table->string('chairperson')->nullable()->after('category_name');
            $table->string('co_chairperson')->nullable()->after('category_name');
            $table->string('moderator')->nullable()->after('category_name');
            $table->string('duration')->nullable()->after('category_name');
            $table->string('sub_heading')->nullable()->after('category_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scientific_session_categories', function (Blueprint $table) {
            //
        });
    }
};
