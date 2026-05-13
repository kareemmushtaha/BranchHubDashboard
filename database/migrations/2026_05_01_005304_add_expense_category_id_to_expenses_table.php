<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultCategoryId = DB::table('expense_categories')->insertGetId([
            'name' => 'Daily Expenses',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('expense_category_id')
                ->nullable()
                ->after('item_name')
                ->constrained('expense_categories')
                ->nullOnDelete();
        });

        DB::table('expenses')->whereNull('expense_category_id')->update([
            'expense_category_id' => $defaultCategoryId,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('expense_category_id');
        });

        DB::table('expense_categories')->where('name', 'Daily Expenses')->delete();
    }
};
