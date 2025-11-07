<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم إداري افتراضي
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@branchhub.com',
            'password' => Hash::make('admin123'),
            'user_type' => 'admin',
            'phone' => '0500000000',
            'status' => 'active',
        ]);

        // إنشاء مستخدم إداري إضافي
        User::create([
            'name' => 'مستخدم إداري',
            'email' => 'manager@branchhub.com',
            'password' => Hash::make('manager123'),
            'user_type' => 'manager',
            'phone' => '0500000001',
            'status' => 'active',
        ]);

        $this->command->info('تم إنشاء المستخدمين الإداريين بنجاح!');
        $this->command->info('مدير النظام: admin@branchhub.com / admin123');
        $this->command->info('مستخدم إداري: manager@branchhub.com / manager123');
    }
}
