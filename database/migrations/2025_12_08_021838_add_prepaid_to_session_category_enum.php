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
        // إضافة 'prepaid' إلى enum session_category
        DB::statement("ALTER TABLE user_sessions MODIFY COLUMN session_category ENUM('hourly', 'prepaid', 'subscription', 'overtime') DEFAULT 'hourly'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إزالة 'prepaid' من enum session_category
        DB::statement("ALTER TABLE user_sessions MODIFY COLUMN session_category ENUM('hourly', 'subscription', 'overtime') DEFAULT 'hourly'");
    }
};
