<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');

            $table->string('payment_proof')->nullable();  // path file bukti pembayaran
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('total_price')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['package_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
