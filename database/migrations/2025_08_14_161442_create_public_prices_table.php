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
        Schema::create('public_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_overtime_morning', 8, 2)->default(5.00);
            $table->decimal('price_overtime_night', 8, 2)->default(7.00);
            $table->decimal('hourly_rate', 8, 2)->default(5.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_prices');
    }
};
