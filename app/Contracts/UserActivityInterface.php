<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Interface for user activity services.
 */
interface UserActivityInterface
{
    /**
     * Get user activity data including sessions and statistics.
     *
     * @param int $userId
     * @param int $perPage
     * @return array
     */
    public function getUserActivityData(int $userId, int $perPage = 10): array;

    /**
     * Get user activity statistics.
     *
     * @param int $userId
     * @return array
     */
    public function getUserActivityStatistics(int $userId): array;

    /**
     * Get user sessions with pagination.
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserSessions(int $userId, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get user visits by session.
     *
     * @param string $sessionId
     * @return Collection
     */
    public function getUserVisitsBySession(string $sessionId): Collection;

    /**
     * Get user visits with session details.
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserVisitsWithSessions(int $userId, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get user visits grouped by page.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserVisitsByPage(int $userId): Collection;
} 