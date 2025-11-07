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
        Schema::create('session_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('user_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action'); // create, update, delete, add_drink, remove_drink, toggle_payment, etc.
            $table->string('action_type'); // session, payment, drink, internet_cost
            $table->text('description'); // وصف مفصل للعملية
            $table->json('old_values')->nullable(); // القيم القديمة
            $table->json('new_values')->nullable(); // القيم الجديدة
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            // فهارس للبحث السريع
            $table->index(['session_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['action', 'created_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_audit_logs');
    }
};
