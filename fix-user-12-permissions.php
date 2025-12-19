<?php

/**
 * Comprehensive script to fix permissions for user ID 12 (admin@branchhub.com)
 * 
 * Usage: php fix-user-12-permissions.php
 * 
 * This script will:
 * 1. Check user 12 status
 * 2. Check admin role and permissions
 * 3. Ensure admin role has ALL permissions
 * 4. Assign admin role to user 12
 * 5. Clear all caches
 * 6. Verify everything
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;

try {
    echo "========================================\n";
    echo "Fixing Permissions for User ID 12\n";
    echo "========================================\n\n";
    
    // Step 1: Check user 12
    echo "Step 1: Checking user ID 12...\n";
    $user = User::find(12);
    
    if (!$user) {
        echo "ERROR: User with ID 12 not found!\n";
        exit(1);
    }
    
    echo "✓ User found:\n";
    echo "  - ID: {$user->id}\n";
    echo "  - Name: {$user->name}\n";
    echo "  - Email: {$user->email}\n";
    echo "  - User Type: {$user->user_type}\n";
    echo "  - Status: {$user->status}\n\n";
    
    // Step 2: Check current roles
    echo "Step 2: Checking current roles...\n";
    $currentRoles = $user->getRoleNames();
    echo "  Current roles: " . ($currentRoles->count() > 0 ? $currentRoles->implode(', ') : 'NONE') . "\n";
    
    // Check role assignments in database
    $roleAssignments = DB::table('model_has_roles')
        ->where('model_id', 12)
        ->where('model_type', 'App\Models\User')
        ->get();
    echo "  Role assignments in DB: " . $roleAssignments->count() . "\n";
    foreach ($roleAssignments as $assignment) {
        $role = Role::find($assignment->role_id);
        echo "    - Role ID {$assignment->role_id}: " . ($role ? $role->name : 'NOT FOUND') . "\n";
    }
    echo "\n";
    
    // Step 3: Check admin role
    echo "Step 3: Checking admin role...\n";
    $adminRole = Role::where('name', 'admin')->first();
    
    if (!$adminRole) {
        echo "  Creating admin role...\n";
        $adminRole = Role::create(['name' => 'admin']);
        echo "  ✓ Admin role created\n";
    } else {
        echo "  ✓ Admin role found (ID: {$adminRole->id})\n";
    }
    
    // Step 4: Check and assign all permissions to admin role
    echo "\nStep 4: Ensuring admin role has ALL permissions...\n";
    $allPermissions = Permission::all();
    echo "  Total permissions in system: " . $allPermissions->count() . "\n";
    
    if ($allPermissions->count() == 0) {
        echo "  WARNING: No permissions found! Run: php artisan db:seed --class=PermissionSeeder\n";
        echo "  Attempting to seed permissions...\n";
        \Artisan::call('db:seed', ['--class' => 'PermissionSeeder']);
        $allPermissions = Permission::all();
        echo "  Permissions after seeding: " . $allPermissions->count() . "\n";
    }
    
    // Get current permissions for admin role
    $adminPermissions = $adminRole->permissions;
    echo "  Current admin role permissions: " . $adminPermissions->count() . "\n";
    
    // Sync all permissions to admin role
    $adminRole->syncPermissions($allPermissions);
    echo "  ✓ Assigned all " . $allPermissions->count() . " permissions to admin role\n";
    
    // Verify
    $adminRole->refresh();
    $adminPermissionsAfter = $adminRole->permissions;
    echo "  Verified admin role permissions: " . $adminPermissionsAfter->count() . "\n\n";
    
    // Step 5: Assign admin role to user 12
    echo "Step 5: Assigning admin role to user 12...\n";
    if (!$user->hasRole('admin')) {
        $user->assignRole('admin');
        echo "  ✓ Admin role assigned to user\n";
    } else {
        echo "  ✓ User already has admin role\n";
    }
    
    // Step 6: Refresh and verify
    echo "\nStep 6: Verifying user permissions...\n";
    $user->refresh();
    $userRoles = $user->getRoleNames();
    $userPermissions = $user->getAllPermissions();
    
    echo "  User roles: " . $userRoles->implode(', ') . "\n";
    echo "  User total permissions: " . $userPermissions->count() . "\n";
    
    // Step 7: Clear all caches
    echo "\nStep 7: Clearing all caches...\n";
    
    // Clear permission cache
    try {
        \Artisan::call('permission:cache-reset');
        echo "  ✓ Permission cache cleared via command\n";
    } catch (\Exception $e) {
        // Alternative method
        $permissionRegistrar = app(PermissionRegistrar::class);
        $permissionRegistrar->forgetCachedPermissions();
        Cache::forget('spatie.permission.cache');
        echo "  ✓ Permission cache cleared via direct method\n";
    }
    
    // Clear other caches
    \Artisan::call('config:clear');
    echo "  ✓ Config cache cleared\n";
    
    \Artisan::call('route:clear');
    echo "  ✓ Route cache cleared\n";
    
    \Artisan::call('cache:clear');
    echo "  ✓ Application cache cleared\n";
    
    // Step 8: Final verification
    echo "\nStep 8: Final verification...\n";
    $user->refresh();
    $finalRoles = $user->getRoleNames();
    $finalPermissions = $user->getAllPermissions();
    
    echo "  User ID: {$user->id}\n";
    echo "  User Email: {$user->email}\n";
    echo "  Has admin role: " . ($user->hasRole('admin') ? 'YES ✓' : 'NO ✗') . "\n";
    echo "  Total roles: " . $finalRoles->count() . "\n";
    echo "  Total permissions: " . $finalPermissions->count() . "\n";
    
    // Check some key permissions
    $keyPermissions = [
        'view dashboard',
        'view users',
        'show user details',
        'create users',
        'edit users',
        'delete users',
        'view sessions',
        'create sessions',
        'edit sessions',
        'delete sessions',
    ];
    
    echo "\n  Checking key permissions:\n";
    foreach ($keyPermissions as $permName) {
        $hasPerm = $user->can($permName);
        echo "    - {$permName}: " . ($hasPerm ? 'YES ✓' : 'NO ✗') . "\n";
    }
    
    echo "\n========================================\n";
    echo "SUCCESS: User 12 should now have full access!\n";
    echo "========================================\n";
    echo "\nUser can now:\n";
    echo "  - Access dashboard\n";
    echo "  - View and manage all users\n";
    echo "  - View and manage all sessions\n";
    echo "  - Access all features in the system\n";
    echo "\nPlease try logging in again with: admin@branchhub.com\n";
    
} catch (\Exception $e) {
    echo "\n========================================\n";
    echo "ERROR OCCURRED\n";
    echo "========================================\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

