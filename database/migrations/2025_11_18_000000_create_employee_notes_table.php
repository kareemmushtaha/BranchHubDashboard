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
        Schema::create('employee_notes', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name'); // اسم الموظف
            $table->date('note_date'); // تاريخ الملاحظة
            $table->string('title')->nullable(); // عنوان الملاحظة
            $table->text('content'); // التفاصيل
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // المستخدم الذي أضاف الملاحظة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_notes');
    }
};

