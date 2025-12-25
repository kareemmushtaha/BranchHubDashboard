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
        Schema::table('session_audit_logs', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['session_id']);
            
            // Make session_id nullable
            $table->foreignId('session_id')->nullable()->change();
            
            // Re-add the foreign key constraint with nullable
            $table->foreign('session_id')->references('id')->on('user_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_audit_logs', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['session_id']);
            
            // Make session_id not nullable again
            $table->foreignId('session_id')->nullable(false)->change();
            
            // Re-add the foreign key constraint
            $table->foreign('session_id')->references('id')->on('user_sessions')->onDelete('cascade');
        });
    }
};
