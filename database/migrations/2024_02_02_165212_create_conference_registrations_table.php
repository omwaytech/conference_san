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
        Schema::create('conference_registrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('conference_id')->nullable();
            $table->tinyInteger('registrant_type')->nullable(); // 1 for attendee, 2 for presenter
            $table->tinyInteger('attend_type')->default(1); // 1 for physical. 2 for online
            $table->string('payment_voucher')->nullable();
            $table->string('transaction_id')->nullable();
            $table->tinyInteger('verified_status')->default(0); // 0 for pending, 1 for accepted, 2 for rejected
            $table->string('amount')->nullable();
            $table->string('token')->nullable();
            $table->tinyInteger('total_attendee')->nullable();
            $table->boolean('is_invited')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->longText('remarks')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_registrations');
    }
};
