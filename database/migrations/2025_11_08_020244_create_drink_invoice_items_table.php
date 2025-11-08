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
        Schema::create('drink_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drink_invoice_id')->constrained('drink_invoices')->onDelete('cascade');
            $table->foreignId('drink_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2);
            $table->enum('status', ['ordered', 'served', 'cancelled'])->default('ordered');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drink_invoice_items');
    }
};
