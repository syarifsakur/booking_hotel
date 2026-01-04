<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                  ->constrained('bookings')
                  ->cascadeOnDelete();

            $table->foreignId('room_id')
                  ->constrained('rooms')
                  ->cascadeOnDelete();

            $table->integer('price_per_night');
            $table->integer('qty')->default(1);
            $table->integer('subtotal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};