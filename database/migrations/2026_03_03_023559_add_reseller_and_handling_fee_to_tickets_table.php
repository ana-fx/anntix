<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('reseller_fee_type')->nullable()->after('organizer_fee_reseller');
            $table->decimal('reseller_fee_value', 15, 2)->nullable()->after('reseller_fee_type');
            $table->string('handling_fee_type')->nullable()->after('reseller_fee_value');
            $table->decimal('handling_fee_value', 15, 2)->nullable()->after('handling_fee_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'reseller_fee_type',
                'reseller_fee_value',
                'handling_fee_type',
                'handling_fee_value',
            ]);
        });
    }
};
