<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * Service for handling role-related business logic.
 */
class RoleService
{
    protected $roleRepository;

    /**
     * RoleService constructor.
     *
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Retrieve all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles()
    {
        return $this->roleRepository->getAllRoles();
    }

    /**
     * Create a new role.
     *
     * @param array $data
     * @return \Spatie\Permission\Models\Role
     * @throws \Exception
     */
    public function createRole(array $data,?array $permissions = null)
    {
        return DB::transaction(function () use ($data, $permissions) {
            $role = $this->roleRepository->createRole($data);

            if ($permissions) {
                $this->roleRepository->syncPermissions($role->id, $permissions);
            }

            return $role;
        });
    }

    /**
     * Find a role by ID.
     *
     * @param int $id
     * @return \Spatie\Permission\Models\Role
     * @throws ModelNotFoundException
     */
    public function findRole($id)
    {
        return $this->roleRepository->findRole($id);
    }

    /**
     * Update an existing role.
     *
     * @param int $id
     * @param array $data
     * @return \Spatie\Permission\Models\Role
     * @throws \Exception
     */
    public function updateRole($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->roleRepository->updateRole($id, $data);
        });
    }

    /**
     * Delete a role.
     *
     * @param int $id
     * @throws \Exception
     */
    public function deleteRole($id)
    {
        return DB::transaction(function () use ($id) {
            $this->roleRepository->deleteRole($id);
        });
    }

    /**
     * Assign permissions to a role.
     *
     * @param int $id
     * @param array $permissions
     * @throws \Exception
     */
    public function assignPermissions($id, array $permissions)
    {
        return DB::transaction(function () use ($id, $permissions) {
            $this->roleRepository->syncPermissions($id, $permissions);
        });
    }
}