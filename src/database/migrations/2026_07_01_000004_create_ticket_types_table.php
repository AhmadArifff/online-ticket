<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->references('id')->on('events')->cascadeOnDelete()->index();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('quota');
            $table->integer('sold')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};
                $table->unsignedBigInteger('event_id')->index();
                $table->foreign('event_id', 'fk_ticket_types_event_id')->references('id')->on('events')->onDelete('cascade');
