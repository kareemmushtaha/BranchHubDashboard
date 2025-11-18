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
        Schema::table('public_prices', function (Blueprint $table) {
            $table->decimal('overtime_rate', 8, 2)->default(5.00)->after('hourly_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_prices', function (Blueprint $table) {
            $table->dropColumn('overtime_rate');
        });
    }
};
