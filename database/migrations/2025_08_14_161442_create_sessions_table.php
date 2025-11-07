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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->enum('session_status', ['active', 'completed', 'cancelled'])->default('active');
            $table->enum('session_category', ['hourly', 'prepaid', 'subscription', 'overtime'])->default('hourly');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('session_type_id')->constrained()->onDelete('cascade');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
