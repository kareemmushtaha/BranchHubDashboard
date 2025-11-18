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
        Schema::create('electricity_meter_readings', function (Blueprint $table) {
            $table->id();
            $table->decimal('morning_reading', 10, 2); // قراءة العداد صباحاً
            $table->decimal('afternoon_reading', 10, 2); // قراءة العداد عصراً
            $table->decimal('evening_reading', 10, 2); // قراءة العداد مساءً
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المستخدم الذي أدخل القراءة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_meter_readings');
    }
};
