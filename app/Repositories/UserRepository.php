<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * Repository for handling user-related database operations.
 */
class UserRepository
{
    /**
     * Retrieve all users with their roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return User::query()->with('roles')->get();
    }

    /**
     * Search users by name or email with optional role filtering.
     *
     * @param string|null $search
     * @param array|null $roleNames
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchUsers(?string $search = null, ?array $roleNames = null)
    {
        $query = User::query()->with('roles');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleNames) {
            $query->whereHas('roles', function ($q) use ($roleNames) {
                $q->whereIn('name', $roleNames);
            });
        }

        return $query->get();
    }

    /**
     * Retrieve users filtered by roles.
     *
     * @param array $roleNames
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersByRoles(array $roleNames)
    {
        return User::query()->with('roles')->whereHas('roles', function ($query) use ($roleNames) {
            $query->whereIn('name', $roleNames);
        })->get();
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function createUser(array $data)
    {
        return User::create($data);
    }

    /**
     * Find a user by ID with roles.
     *
     * @param int $id
     * @return \App\Models\User
     */
    public function findUser($id)
    {
        return User::query()->with('roles')->findOrFail($id);
    }

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\User
     */
    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    /**
     * Delete a user.
     *
     * @param int $id
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    /**
     * Sync roles for a user.
     *
     * @param int $id
     * @param array $roles
     */
    public function syncRoles($id, array $roles)
    {
        $user = User::findOrFail($id);
        $user->syncRoles($roles);
    }

    /**
     * Toggle user active status.
     *
     * @param int $id
     * @param bool $isActive
     */
    public function toggleUserStatus($id, bool $isActive)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => $isActive]);
        
    }
}
