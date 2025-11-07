<?php

namespace Database\Seeders;

use App\Models\Drink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drinks = [
            ['name' => 'شاي', 'price' => 2.00, 'size' => 'medium', 'status' => 'available'],
            ['name' => 'قهوة', 'price' => 3.00, 'size' => 'medium', 'status' => 'available'],
            ['name' => 'عصير برتقال', 'price' => 4.00, 'size' => 'large', 'status' => 'available'],
            ['name' => 'مياه', 'price' => 1.00, 'size' => 'medium', 'status' => 'available'],
            ['name' => 'مشروب غازي', 'price' => 2.50, 'size' => 'medium', 'status' => 'available'],
            ['name' => 'عصير تفاح', 'price' => 3.50, 'size' => 'medium', 'status' => 'available'],
            ['name' => 'شاي أخضر', 'price' => 2.50, 'size' => 'small', 'status' => 'available'],
            ['name' => 'نسكافيه', 'price' => 3.50, 'size' => 'large', 'status' => 'available'],
        ];

        foreach ($drinks as $drink) {
            Drink::create($drink);
        }
    }
}
