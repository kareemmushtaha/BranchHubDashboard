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
        Schema::table('leaders', function (Blueprint $table) {
            $table->string('job_title')->nullable()->after('phone');
            $table->text('job_description')->nullable()->after('job_title');
            $table->string('linkedin')->nullable()->after('job_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaders', function (Blueprint $table) {
            $table->dropColumn(['job_title', 'job_description', 'linkedin']);
        });
    }
};
