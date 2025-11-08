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
        // إزالة 'prepaid' من enum user_type
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('hourly', 'subscription', 'admin', 'manager') DEFAULT 'hourly'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة 'prepaid' إلى enum user_type
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('hourly', 'prepaid', 'subscription', 'admin', 'manager') DEFAULT 'hourly'");
    }
};
