<?php

/**
 * Quick script to assign admin role to a user
 * 
 * Usage: php assign-admin-role.php admin@branchhub.com
 * 
 * Run this from the project root directory
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

// Get email from command line argument
$email = $argv[1] ?? null;

if (!$email) {
    echo "Usage: php assign-admin-role.php user@example.com\n";
    exit(1);
}

try {
    // Find the user
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        echo "ERROR: User with email '{$email}' not found.\n";
        exit(1);
    }
    
    // Find or create admin role
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    
    // Check if user already has admin role
    if ($user->hasRole('admin')) {
        echo "INFO: User '{$email}' already has admin role.\n";
        exit(0);
    }
    
    // Assign admin role
    $user->assignRole('admin');
    
    echo "SUCCESS: Admin role assigned to user: {$email}\n";
    echo "User: {$user->name} ({$user->email})\n";
    
    // Clear permission cache
    \Artisan::call('permission:cache-reset');
    echo "Permission cache cleared.\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

