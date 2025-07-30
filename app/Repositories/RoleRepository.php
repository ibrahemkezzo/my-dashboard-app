<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

/**
 * Repository for handling role-related database operations.
 */
class RoleRepository
{
    /**
     * Retrieve all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles()
    {
        return Role::query()->get();
    }

    /**
     * Create a new role.
     *
     * @param array $data
     * @return \Spatie\Permission\Models\Role
     */
    public function createRole($data)
    {
        return Role::create($data);
    }

    /**
     * Find a role by ID with permissions.
     *
     * @param int $id
     * @return \Spatie\Permission\Models\Role
     */
    public function findRole($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    /**
     * Update an existing role.
     *
     * @param int $id
     * @param array $data
     * @return \Spatie\Permission\Models\Role
     */
    public function updateRole($id, $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }

    /**
     * Delete a role.
     *
     * @param int $id
     */
    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
    }

    /**
     * Sync permissions for a role.
     *
     * @param int $id
     * @param array $permissions
     */
    public function syncPermissions($id, $permissions)
    {
        $role = Role::findOrFail($id);
        $role->syncPermissions($permissions);
    }
}