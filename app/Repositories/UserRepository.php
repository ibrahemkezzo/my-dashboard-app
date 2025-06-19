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
}
