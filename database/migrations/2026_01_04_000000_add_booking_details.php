<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Tambah field WhatsApp
            $table->string('guest_whatsapp')->nullable()->after('guest_phone');
            
            // Tambah field untuk KTP/ID Photo
            $table->string('guest_ktp_photo')->nullable()->after('guest_whatsapp');
            
            // QR Code
            $table->text('qr_code_data')->nullable()->after('guest_ktp_photo');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['guest_whatsapp', 'guest_ktp_photo', 'qr_code_data']);
        });
    }
};
