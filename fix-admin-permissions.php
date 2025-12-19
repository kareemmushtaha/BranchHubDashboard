<?php

/**
 * Script to fix admin role permissions and assign to user
 * 
 * Usage: php fix-admin-permissions.php admin@branchhub.com
 * 
 * This script will:
 * 1. Ensure all permissions exist
 * 2. Ensure admin role has ALL permissions
 * 3. Assign admin role to the specified user
 * 4. Clear permission cache
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\PermissionRegistrar;

// Get email from command line argument
$email = $argv[1] ?? null;

if (!$email) {
    echo "Usage: php fix-admin-permissions.php user@example.com\n";
    exit(1);
}

try {
    echo "Starting admin permissions fix...\n\n";
    
    // Step 1: Find or create admin role
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    echo "✓ Admin role found/created\n";
    
    // Step 2: Get all permissions
    $allPermissions = Permission::all();
    echo "✓ Found " . $allPermissions->count() . " permissions\n";
    
    // Step 3: Assign ALL permissions to admin role
    $adminRole->syncPermissions($allPermissions);
    echo "✓ Assigned all " . $allPermissions->count() . " permissions to admin role\n";
    
    // Step 4: Find the user
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        echo "\nERROR: User with email '{$email}' not found.\n";
        exit(1);
    }
    
    echo "✓ User found: {$user->name} ({$user->email})\n";
    
    // Step 5: Assign admin role to user
    if (!$user->hasRole('admin')) {
        $user->assignRole('admin');
        echo "✓ Admin role assigned to user\n";
    } else {
        echo "✓ User already has admin role\n";
    }
    
    // Step 6: Refresh user and verify
    $user->refresh();
    $userPermissions = $user->getAllPermissions();
    
    echo "\n=== VERIFICATION ===\n";
    echo "User: {$user->name} ({$user->email})\n";
    echo "Has admin role: " . ($user->hasRole('admin') ? 'YES' : 'NO') . "\n";
    echo "Total permissions: " . $userPermissions->count() . "\n";
    
    // Step 7: Clear all caches
    echo "\nClearing caches...\n";
    try {
        \Artisan::call('permission:cache-reset');
        echo "✓ Permission cache cleared via command\n";
    } catch (\Exception $e) {
        // Alternative method: clear cache directly
        $permissionRegistrar = app(PermissionRegistrar::class);
        $permissionRegistrar->forgetCachedPermissions();
        Cache::forget('spatie.permission.cache');
        echo "✓ Permission cache cleared via direct method\n";
    }
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
    echo "✓ All other caches cleared\n";
    
    echo "\n=== SUCCESS ===\n";
    echo "Admin role has been properly configured and assigned.\n";
    echo "User should now have full access to all features.\n";
    
} catch (\Exception $e) {
    echo "\nERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

