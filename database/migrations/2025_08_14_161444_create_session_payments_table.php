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
        Schema::create('session_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('user_sessions')->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->decimal('amount_bank', 10, 2)->default(0);
            $table->decimal('amount_cash', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'paid', 'partial', 'cancelled'])->default('pending');
            $table->decimal('remaining_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_payments');
    }
};
