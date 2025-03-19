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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('gender')->nullable();
            $table->bigInteger('member_type_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('institute_name')->nullable();
            $table->bigInteger('country_id')->nullable();
            $table->string('council_number')->nullable();
            $table->string('san_number')->nullable();
            $table->tinyInteger('is_faculty')->default(0);
            $table->string('pass_designation')->nullable();
            $table->string('pass_sub_designation')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
