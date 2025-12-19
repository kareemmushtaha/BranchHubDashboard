<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم إداري افتراضي
        $admin = User::firstOrCreate(
            ['email' => 'admin@branchhub.com'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('admin123'),
                'user_type' => 'admin',
                'phone' => '0500000000',
                'status' => 'active',
            ]
        );

        // إنشاء مستخدم إداري إضافي
        $manager = User::firstOrCreate(
            ['email' => 'manager@branchhub.com'],
            [
                'name' => 'مستخدم إداري',
                'password' => Hash::make('manager123'),
                'user_type' => 'manager',
                'phone' => '0500000001',
                'status' => 'active',
            ]
        );

        // تعيين الأدوار للمستخدمين
        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();

        if ($adminRole && !$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        if ($managerRole && !$manager->hasRole('manager')) {
            $manager->assignRole('manager');
        }

        // تعيين دور admin لجميع المستخدمين الإداريين الموجودين
        if ($adminRole) {
            $existingAdmins = User::where('user_type', 'admin')->get();
            foreach ($existingAdmins as $existingAdmin) {
                if (!$existingAdmin->hasRole('admin')) {
                    $existingAdmin->assignRole('admin');
                    $this->command->info("تم تعيين دور admin للمستخدم: {$existingAdmin->email}");
                }
            }
        }

        // تعيين دور manager لجميع المستخدمين من نوع manager الموجودين
        if ($managerRole) {
            $existingManagers = User::where('user_type', 'manager')->get();
            foreach ($existingManagers as $existingManager) {
                if (!$existingManager->hasRole('manager')) {
                    $existingManager->assignRole('manager');
                    $this->command->info("تم تعيين دور manager للمستخدم: {$existingManager->email}");
                }
            }
        }

        $this->command->info('تم إنشاء المستخدمين الإداريين بنجاح!');
        $this->command->info('مدير النظام: admin@branchhub.com / admin123');
        $this->command->info('مستخدم إداري: manager@branchhub.com / manager123');
    }
}
