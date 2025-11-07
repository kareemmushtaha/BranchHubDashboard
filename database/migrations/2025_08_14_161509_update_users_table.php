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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['hourly', 'prepaid', 'subscription'])->default('hourly');
            $table->string('phone')->nullable();
            $table->date('subscription_end_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'phone', 'subscription_end_date', 'status']);
        });
    }
};
