<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom drive_link
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('drive_link')->nullable()->after('payment_proof');
        });

        // 2. Modify enum status — MySQL tidak support langsung via Blueprint,
        //    harus pakai raw statement
        DB::statement("
            ALTER TABLE bookings
            MODIFY COLUMN status
            ENUM('pending','confirmed','rejected','completed','editing','done')
            NOT NULL DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        // Kembalikan enum ke semula
        DB::statement("
            ALTER TABLE bookings
            MODIFY COLUMN status
            ENUM('pending','confirmed','rejected')
            NOT NULL DEFAULT 'pending'
        ");

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('drive_link');
        });
    }
};
