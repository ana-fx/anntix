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
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('organizer_fee_online_type')->nullable(); // fixed/percent
            $table->decimal('organizer_fee_online', 15, 2)->nullable();
            $table->string('organizer_fee_reseller_type')->nullable(); // fixed/percent 
            $table->decimal('organizer_fee_reseller', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'organizer_fee_online_type',
                'organizer_fee_online',
                'organizer_fee_reseller_type',
                'organizer_fee_reseller',
            ]);
        });
    }
};
