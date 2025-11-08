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
        // تحديث enum user_type لإضافة قيم admin و manager
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('hourly', 'prepaid', 'subscription', 'admin', 'manager') DEFAULT 'hourly'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة الحقل إلى القيم الأصلية
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('hourly', 'prepaid', 'subscription') DEFAULT 'hourly'");
    }
};
