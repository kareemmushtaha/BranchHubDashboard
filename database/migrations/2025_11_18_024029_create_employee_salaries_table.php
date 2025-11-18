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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name'); // اسم الموظف
            $table->date('salary_date')->nullable(); // تاريخ الراتب (يمكن تحديده يدوياً)
            $table->decimal('cash_amount', 10, 2)->default(0); // المبلغ الكاش
            $table->decimal('bank_amount', 10, 2)->default(0); // المبلغ البنكي
            $table->enum('transfer_type', ['partial', 'full'])->default('full'); // نوع الحوالة (راتب جزئي - راتب كامل)
            $table->text('notes')->nullable(); // ملاحظات
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المستخدم الذي أضاف الراتب
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salaries');
    }
};
