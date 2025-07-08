<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Service for handling user-related business logic.
 */
class UserService
{
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieve all users with their roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    /**
     * Get filtered and paginated users.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilteredUsers(array $filters = [], int $perPage = 15)
    {
        return $this->userRepository->getFilteredUsers($filters, $perPage);
    }

    /**
     * Retrieve users filtered by roles.
     *
     * @param array|null $roleNames
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersByRoles(?array $roleNames = null)
    {
        if (empty($roleNames)) {
            return $this->getAllUsers();
        }
        return $this->userRepository->getUsersByRoles($roleNames);
    }

    /**
     * Create a new user with optional roles.
     *
     * @param array $data
     * @param array|null $roles
     * @return \App\Models\User
     * @throws \Exception
     */
    public function createUser(array $data, ?array $roles = null)
    {
        return DB::transaction(function () use ($data, $roles) {
            $userData = [
                'name' => trim($data['name']),
                'email' => trim($data['email']),
                'phone_number' => trim($data['phone_number']),
                'city_id' => trim($data['city_id']),
                'password' => Hash::make($data['password']),
            ];

            $user = $this->userRepository->createUser($userData);

            if ($roles) {
                $this->userRepository->syncRoles($user->id, $roles);
            }

            return $user;
        });
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return \App\Models\User
     * @throws ModelNotFoundException
     */
    public function findUser($id)
    {
        return $this->userRepository->findUser($id);
    }

    /**
     * Update an existing user with optional roles.
     *
     * @param int $id
     * @param array $data
     * @param array|null $roles
     * @return \App\Models\User
     * @throws \Exception
     */
    public function updateUser($id, array $data, ?array $roles = null)
    {
        return DB::transaction(function () use ($id, $data, $roles) {
            $userData = [
                'name' => trim($data['name']),
                'email' => trim($data['email']),
                'phone_number' => trim($data['phone_number']),
                'city_id' => trim($data['city_id']),
            ];

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            $user = $this->userRepository->updateUser($id, $userData);

            if ($roles) {
                $this->userRepository->syncRoles($id, $roles);
            }

            return $user;
        });
    }

    /**
     * Delete a user.
     *
     * @param int $id
     * @throws \Exception
     */
    public function deleteUser($id)
    {
        return DB::transaction(function () use ($id) {
            $this->userRepository->deleteUser($id);
        });
    }

    /**
     * Assign roles to a user.
     *
     * @param int $id
     * @param array $roles
     * @throws \Exception
     */
    public function assignRoles($id, array $roles)
    {
        return DB::transaction(function () use ($id, $roles) {
            $this->userRepository->syncRoles($id, $roles);
        });
    }

    /**
     * Toggle user active status.
     *
     * @param int $id
     * @param bool $isActive
     * @throws \Exception
     */
    public function toggleUserStatus($id, bool $isActive)
    {
        return DB::transaction(function () use ($id, $isActive) {
            $this->userRepository->toggleUserStatus($id, $isActive);
        });
    }
}
