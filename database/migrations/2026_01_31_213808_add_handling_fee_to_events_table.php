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
        Schema::table('events', function (Blueprint $table) {
            $table->enum('handling_fee_type', ['default', 'percent', 'fixed'])->default('default')->after('reseller_fee_value');
            $table->decimal('handling_fee_value', 12, 2)->default(0)->after('handling_fee_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['handling_fee_type', 'handling_fee_value']);
        });
    }
};
