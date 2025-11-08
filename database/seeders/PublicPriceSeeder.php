<?php

namespace Database\Seeders;

use App\Models\PublicPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PublicPrice::create([
            'price_overtime_morning' => 5.00,
            'price_overtime_night' => 7.00,
            'hourly_rate' => 5.00,
        ]);
    }
}
