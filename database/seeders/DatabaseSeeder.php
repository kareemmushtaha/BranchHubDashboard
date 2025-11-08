<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء مستخدم تجريبي
        User::factory()->create([
            'name' => 'مدير النظام',
            'email' => 'admin@workspace.com',
            'user_type' => 'hourly',
            'phone' => '1234567890',
            'status' => 'active'
        ]);
        
        // إنشاء بعض المستخدمين التجريبيين
        User::factory(10)->create();

        // تشغيل الـ Seeders
        $this->call([
            DrinkSeeder::class,
            PublicPriceSeeder::class,
        ]);
    }
}
