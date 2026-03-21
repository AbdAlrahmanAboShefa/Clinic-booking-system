<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy('group');
        
        return view('admin.permissions.index', compact('roles', 'permissions'));
    }

    public function assignRoleToUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user->assignRole($validated['role']);
        
        $this->flashSuccess("Role '{$validated['role']}' assigned to {$user->name} successfully.");
        
        return back();
    }

    public function removeRoleFromUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        if (!$user->hasRole($validated['role'])) {
            $this->flashError("User doesn't have the role '{$validated['role']}'.");
            return back();
        }

        $user->removeRole($validated['role']);
        
        $this->flashSuccess("Role '{$validated['role']}' removed from {$user->name} successfully.");
        
        return back();
    }

    public function syncRolesToUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name'
        ]);

        $user->syncRoles($validated['roles']);
        
        $this->flashSuccess("User roles updated successfully.");
        
        return back();
    }

    public function givePermissionToRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permission' => 'required|exists:permissions,name'
        ]);

        $role->givePermissionTo($validated['permission']);
        
        $this->flashSuccess("Permission '{$validated['permission']}' added to role '{$role->name}'.");
        
        return back();
    }

    public function revokePermissionFromRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permission' => 'required|exists:permissions,name'
        ]);

        if (!$role->hasPermissionTo($validated['permission'])) {
            $this->flashError("Role doesn't have the permission '{$validated['permission']}'.");
            return back();
        }

        $role->revokePermissionTo($validated['permission']);
        
        $this->flashSuccess("Permission '{$validated['permission']}' removed from role '{$role->name}'.");
        
        return back();
    }

    public function syncPermissionsToRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->syncPermissions($validated['permissions']);
        
        $this->flashSuccess("Role permissions updated successfully.");
        
        return back();
    }

    public function assignRoleToUserPage()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        
        return view('admin.permissions.assign-role', compact('users', 'roles'));
    }

    public function manageUserRoles(User $user)
    {
        $user->load('roles');
        $roles = Role::all();
        
        return view('admin.permissions.user-roles', compact('user', 'roles'));
    }

    public function manageRolePermissions(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::all()->groupBy('group');
        
        return view('admin.permissions.role-permissions', compact('role', 'permissions'));
    }
}
