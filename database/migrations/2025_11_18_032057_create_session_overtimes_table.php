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
        Schema::create('session_overtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('user_sessions')->onDelete('cascade');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->decimal('total_hour', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_overtimes');
    }
};
