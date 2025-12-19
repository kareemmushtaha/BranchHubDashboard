<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();
        
        // Group permissions by category
        $permissionsByCategory = $this->groupPermissionsByCategory($permissions);
        
        return view('roles.index', compact('roles', 'permissions', 'permissionsByCategory'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', 'تم إنشاء الدور بنجاح.');
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $request->name]);
        
        // Sync permissions
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'تم تحديث الدور بنجاح.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of admin role
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')
                ->with('error', 'لا يمكن حذف دور المدير.');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'تم حذف الدور بنجاح.');
    }

    /**
     * Show the form for editing a role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $permissionsByCategory = $this->groupPermissionsByCategory($permissions);
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('roles.edit', compact('role', 'permissions', 'permissionsByCategory', 'rolePermissions'));
    }

    /**
     * Group permissions by category for better organization.
     */
    private function groupPermissionsByCategory($permissions)
    {
        $categories = [
            'Dashboard' => ['view dashboard', 'view dashboard real-time'],
            'Users' => ['view users', 'show user details', 'create users', 'edit users', 'delete users', 'view users monthly', 'view users hourly', 'view users prepaid', 'charge user wallet', 'deduct user wallet', 'add user debt', 'delete user wallet transactions', 'update user wallet transaction', 'view user wallet history', 'restore users', 'force delete users', 'bulk destroy users', 'bulk restore users', 'bulk force delete users'],
            'Sessions' => ['view sessions', 'create sessions', 'edit sessions', 'delete sessions', 'view sessions overdue', 'create session for user', 'end session', 'cancel session', 'complete and deduct session', 'add drink to session', 'update session drink date', 'update session drink price', 'remove drink from session', 'add overtime to session', 'update overtime rate', 'update overtime', 'remove overtime from session', 'restore sessions', 'force delete sessions', 'bulk destroy sessions', 'bulk restore sessions', 'bulk force delete sessions', 'update session start time', 'update session end time', 'view real-time stats', 'update expected end date', 'end subscription session', 'update session note', 'pause session', 'resume session'],
            'Session Payments' => ['view session payments', 'create session payments', 'edit session payments', 'delete session payments', 'generate session payment invoice', 'view session payment invoice'],
            'Drinks' => ['view drinks', 'create drinks', 'edit drinks', 'delete drinks'],
            'Drink Invoices' => ['view drink invoices', 'create drink invoices', 'edit drink invoices', 'delete drink invoices', 'add drink to invoice', 'remove drink from invoice', 'update drink invoice date', 'update drink invoice price', 'generate drink invoice', 'view drink invoice'],
            'Calendar Notes' => ['view calendar notes', 'create calendar notes', 'edit calendar notes', 'delete calendar notes'],
            'Employee Notes' => ['view employee notes', 'create employee notes', 'edit employee notes', 'delete employee notes'],
            'Reports' => ['view reports', 'view revenue reports', 'view users reports', 'view drinks reports'],
            'Audit' => ['view session audit', 'view audit', 'export audit'],
            'Session Pricing' => ['update internet cost', 'update internet cost form', 'view session pricing', 'update all pricing'],
            'Expenses' => ['view expenses', 'create expenses', 'edit expenses', 'delete expenses'],
            'Employee Salaries' => ['view employee salaries', 'create employee salaries', 'edit employee salaries', 'delete employee salaries'],
            'Electricity Meter Readings' => ['view electricity meter readings', 'create electricity meter readings', 'edit electricity meter readings', 'delete electricity meter readings'],
            'Booking Requests' => ['view booking requests', 'edit booking requests', 'delete booking requests', 'update booking request status'],
            'Roles & Permissions' => ['view roles', 'create roles', 'edit roles', 'delete roles', 'view permissions', 'assign permissions'],
        ];

        $grouped = [];
        foreach ($permissions as $permission) {
            $found = false;
            foreach ($categories as $category => $categoryPermissions) {
                if (in_array($permission->name, $categoryPermissions)) {
                    if (!isset($grouped[$category])) {
                        $grouped[$category] = [];
                    }
                    $grouped[$category][] = $permission;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                if (!isset($grouped['Other'])) {
                    $grouped['Other'] = [];
                }
                $grouped['Other'][] = $permission;
            }
        }

        return $grouped;
    }
}

