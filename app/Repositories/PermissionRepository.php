<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

/**
 * Repository for handling permission-related database operations.
 */
class PermissionRepository
{
    /**
     * Retrieve all permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPermissions()
    {
        return Permission::query()->get();
    }

    /**
     * Create a new permission.
     *
     * @param array $data
     * @return \Spatie\Permission\Models\Permission
     */
    public function createPermission(array $data)
    {
        return Permission::create($data);
    }

    /**
     * Find a permission by ID.
     *
     * @param int $id
     * @return \Spatie\Permission\Models\Permission
     */
    public function findPermission($id)
    {
        return Permission::findOrFail($id);
    }

    /**
     * Update an existing permission.
     *
     * @param int $id
     * @param array $data
     * @return \Spatie\Permission\Models\Permission
     */
    public function updatePermission($id, array $data)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($data);
        return $permission;
    }

    /**
     * Delete a permission.
     *
     * @param int $id
     */
    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
    }
}