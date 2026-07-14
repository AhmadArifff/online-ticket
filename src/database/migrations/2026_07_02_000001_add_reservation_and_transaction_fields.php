<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            if (!Schema::hasColumn('payments', 'transaction_id')) {

                $table->string('transaction_id')
                    ->nullable()
                    ->after('payment_method');

                $table->unique(
                    'transaction_id',
                    'uk_payments_transaction_id'
                );
            }

        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            if (Schema::hasColumn('payments', 'transaction_id')) {

                $table->dropUnique('uk_payments_transaction_id');

                $table->dropColumn('transaction_id');

            }

        });
    }
};