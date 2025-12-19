<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions based on routes
        $permissions = [
            // Dashboard
            'view dashboard',
            'view dashboard real-time',
            
            // Users
            'view users',
            'show user details',
            'create users',
            'edit users',
            'delete users',
            'view users monthly',
            'view users hourly',
            'view users prepaid',
            'charge user wallet',
            'deduct user wallet',
            'add user debt',
            'delete user wallet transactions',
            'update user wallet transaction',
            'view user wallet history',
            'restore users',
            'force delete users',
            'bulk destroy users',
            'bulk restore users',
            'bulk force delete users',
            
            // Sessions
            'view sessions',
            'create sessions',
            'edit sessions',
            'delete sessions',
            'view sessions overdue',
            'view trashed sessions',
            'create session for user',
            'end session',
            'cancel session',
            'complete and deduct session',
            'add drink to session',
            'update session drink date',
            'update session drink price',
            'remove drink from session',
            'add overtime to session',
            'update overtime rate',
            'update overtime',
            'remove overtime from session',
            'restore sessions',
            'force delete sessions',
            'bulk destroy sessions',
            'bulk restore sessions',
            'bulk force delete sessions',
            'update session start time',
            'update session end time',
            'view real-time stats',
            'update expected end date',
            'end subscription session',
            'update session note',
            'pause session',
            'resume session',
            
            // Session Payments
            'view session payments',
            'create session payments',
            'edit session payments',
            'delete session payments',
            'generate session payment invoice',
            'view session payment invoice',
            
            // Drinks
            'view drinks',
            'create drinks',
            'edit drinks',
            'delete drinks',
            
            // Drink Invoices
            'view drink invoices',
            'create drink invoices',
            'edit drink invoices',
            'delete drink invoices',
            'add drink to invoice',
            'remove drink from invoice',
            'update drink invoice date',
            'update drink invoice price',
            'generate drink invoice',
            'view drink invoice',
            
            // Calendar Notes
            'view calendar notes',
            'create calendar notes',
            'edit calendar notes',
            'delete calendar notes',
            
            // Employee Notes
            'view employee notes',
            'create employee notes',
            'edit employee notes',
            'delete employee notes',
            
            // Reports
            'view reports',
            'view revenue reports',
            'view users reports',
            'view drinks reports',
            
            // Audit
            'view session audit',
            'view audit',
            'export audit',
            
            // Session Pricing
            'update internet cost',
            'update internet cost form',
            'view session pricing',
            'update all pricing',
            
            // Expenses
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',
            
            // Employee Salaries
            'view employee salaries',
            'create employee salaries',
            'edit employee salaries',
            'delete employee salaries',
            
            // Electricity Meter Readings
            'view electricity meter readings',
            'create electricity meter readings',
            'edit electricity meter readings',
            'delete electricity meter readings',
            
            // Booking Requests
            'view booking requests',
            'edit booking requests',
            'delete booking requests',
            'update booking request status',
            
            // Roles & Permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'assign permissions',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create default roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        
        // Assign all permissions to admin role
        $adminRole->givePermissionTo(Permission::all());
        
        // Assign basic permissions to manager role (you can customize this)
        $managerRole->givePermissionTo([
            'view dashboard',
            'view users',
            'show user details',
            'view sessions',
            'view session payments',
            'view drinks',
            'view drink invoices',
            'view calendar notes',
            'view employee notes',
            'view reports',
        ]);

        $this->command->info('Permissions and roles created successfully!');
    }
}

