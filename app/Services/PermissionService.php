<?php

namespace App\Services;

use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * Service for handling permission-related business logic.
 */
class PermissionService
{
    protected $permissionRepository;

    /**
     * PermissionService constructor.
     *
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Retrieve all permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPermissions()
    {
        return $this->permissionRepository->getAllPermissions();
    }

    /**
     * Create a new permission.
     *
     * @param array $data
     * @return \Spatie\Permission\Models\Permission
     * @throws \Exception
     */
    public function createPermission(array $data)
    {
        return DB::transaction(function () use ($data) {
            $cleanedData = [
                'name' => trim($data['name']),
                'description' => isset($data['description']) ? trim($data['description']) : null,
                'guard_name' => 'web', // Default guard for web
            ];

            $permission = $this->permissionRepository->createPermission($cleanedData);

            return $permission;
        });
    }

    /**
     * Find a permission by ID.
     *
     * @param int $id
     * @return \Spatie\Permission\Models\Permission
     * @throws ModelNotFoundException
     */
    public function findPermission($id)
    {
        return $this->permissionRepository->findPermission($id);
    }

    /**
     * Update an existing permission.
     *
     * @param int $id
     * @param array $data
     * @return \Spatie\Permission\Models\Permission
     * @throws \Exception
     */
    public function updatePermission($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $cleanedData = [
                'name' => trim($data['name']),
                'description' => isset($data['description']) ? trim($data['description']) : null,
            ];
            $permission = $this->permissionRepository->updatePermission($id, $cleanedData);
            return $permission;
        });
    }

    /**
     * Delete a permission.
     *
     * @param int $id
     * @throws \Exception
     */
    public function deletePermission($id)
    {
        return DB::transaction(function () use ($id) {
            $this->permissionRepository->deletePermission($id);
        });
    }
}