<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->index();
            $table->foreign('booking_id', 'fk_booking_details_booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('ticket_type_id');
            $table->foreign('ticket_type_id', 'fk_booking_details_ticket_type_id')->references('id')->on('ticket_types')->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
