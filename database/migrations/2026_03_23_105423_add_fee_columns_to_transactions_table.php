<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('unit_price', 12, 2)->after('quantity')->nullable();
            $table->decimal('handling_fee', 12, 2)->after('unit_price')->default(0);
            $table->decimal('service_fee', 12, 2)->after('handling_fee')->default(0);
            $table->decimal('reseller_fee', 12, 2)->after('service_fee')->default(0);
            $table->decimal('organizer_fee', 12, 2)->after('reseller_fee')->default(0);
            $table->decimal('gateway_fee', 12, 2)->after('organizer_fee')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'unit_price',
                'handling_fee',
                'service_fee',
                'reseller_fee',
                'organizer_fee',
                'gateway_fee',
            ]);
        });
    }
};
