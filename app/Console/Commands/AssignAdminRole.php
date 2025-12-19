<?php

namespace App\Console\Commands;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Console\Command;

class AssignAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-admin {email : The email of the user to assign admin role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign admin role to an existing user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Find the user
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }
        
        // Find or create admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Check if user already has admin role
        if ($user->hasRole('admin')) {
            $this->info("User '{$email}' already has admin role.");
            return 0;
        }
        
        // Assign admin role
        $user->assignRole('admin');
        
        $this->info("Successfully assigned admin role to user: {$email}");
        $this->info("User: {$user->name} ({$user->email})");
        
        return 0;
    }
}

