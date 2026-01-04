<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('booking_code')->unique();
            $table->string('qr_token')->unique();

            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone');

            $table->date('check_in');
            $table->date('check_out');
            $table->integer('nights');

            $table->integer('total_price');

            $table->enum('payment_status', ['unpaid', 'paid', 'expired', 'cancelled'])
                  ->default('unpaid');

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};