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
        Schema::table('electricity_meter_readings', function (Blueprint $table) {
            $table->decimal('morning_reading', 10, 2)->nullable()->change();
            $table->decimal('afternoon_reading', 10, 2)->nullable()->change();
            $table->decimal('evening_reading', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('electricity_meter_readings', function (Blueprint $table) {
            $table->decimal('morning_reading', 10, 2)->nullable(false)->change();
            $table->decimal('afternoon_reading', 10, 2)->nullable(false)->change();
            $table->decimal('evening_reading', 10, 2)->nullable(false)->change();
        });
    }
};
