<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Tambah metode pembayaran: cash (bayar langsung) atau transfer
            $table->enum('payment_method', ['cash', 'transfer'])->nullable()->after('payment_status');

            // Tambah bukti pembayaran (gambar)
            if (!Schema::hasColumn('bookings', 'proof_of_payment')) {
                $table->string('proof_of_payment')->nullable()->after('guest_ktp_photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_method']);
            if (Schema::hasColumn('bookings', 'proof_of_payment')) {
                $table->dropColumn('proof_of_payment');
            }
        });
    }
};