<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Tambah kolom photo jika belum ada
            if (!Schema::hasColumn('rooms', 'photo')) {
                $table->string('photo')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
};
