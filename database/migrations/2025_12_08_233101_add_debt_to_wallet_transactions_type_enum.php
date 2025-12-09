<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تعديل enum type لإضافة 'debt'
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('charge', 'deduct', 'refund', 'debt') NOT NULL DEFAULT 'charge'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إزالة 'debt' من enum type
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('charge', 'deduct', 'refund') NOT NULL DEFAULT 'charge'");
    }
};
