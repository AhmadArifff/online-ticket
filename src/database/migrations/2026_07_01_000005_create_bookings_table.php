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

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('booking_code')->unique();

            $table->decimal('total_amount', 10, 2);

            $table->enum('status', [
                'pending',
                'paid',
                'cancelled',
                'expired',
                'reserved'
            ])->default('pending');

            $table->dateTime('reserved_until')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};