<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Interface for visit repository operations.
 */
interface VisitRepositoryInterface
{
    /**
     * Record a new session.
     *
     * @param array $data Session data including session_id, device_type, country, referrer.
     * @return void
     */
    public function recordSession(array $data): void;

    /**
     * Record a new visit.
     *
     * @param array $data Visit data including session_id, page_url.
     * @return void
     */
    public function recordVisit(array $data): void;

    /**
     * Update time spent for a visit.
     *
     * @param string $sessionId
     * @param string $pageUrl
     * @param int $timeSpent
     * @return void
     */
    public function updateTimeSpent(string $sessionId, string $pageUrl, int $timeSpent): void;

    /**
     * Get total number of visits with optional filters.
     *
     * @param array $filters
     * @return int
     */
    public function getTotalVisits(array $filters = []): int;

    /**
     * Get visits grouped by page with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByPage(array $filters = []): array;

    /**
     * Get visits grouped by device type with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByDevice(array $filters = []): array;

    /**
     * Get visits grouped by country with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByCountry(array $filters = []): array;

    /**
     * Get visits grouped by referrer with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByReferrer(array $filters = []): array;

    /**
     * Get average time spent per page with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getAverageTimeSpent(array $filters = []): array;

    /**
     * Get visit trend over a period with optional filters.
     *
     * @param int $days
     * @param array $filters
     * @return array
     */
    public function getVisitTrend(int $days, array $filters = []): array;

    /**
     * Get list of unique countries for filtering.
     *
     * @return Collection
     */
    public function getCountries(): Collection;

    /**
     * Get user sessions with visits.
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserSessions(int $userId, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get user sessions count.
     *
     * @param int $userId
     * @return int
     */
    public function getUserSessionsCount(int $userId): int;

    /**
     * Get user visits count.
     *
     * @param int $userId
     * @return int
     */
    public function getUserVisitsCount(int $userId): int;

    /**
     * Get user last session.
     *
     * @param int $userId
     * @return \App\Models\Session|null
     */
    public function getUserLastSession(int $userId): ?\App\Models\Session;

    /**
     * Get user device types count.
     *
     * @param int $userId
     * @return int
     */
    public function getUserDeviceTypesCount(int $userId): int;

    /**
     * Get visits by session ID.
     *
     * @param string $sessionId
     * @return Collection
     */
    public function getVisitsBySession(string $sessionId): Collection;

    /**
     * Get all visits for a specific user.
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserVisits(int $userId, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get user visits grouped by page with visit count.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserVisitsByPage(int $userId): Collection;

    /**
     * Get user visits with session details.
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserVisitsWithSessions(int $userId, int $perPage = 10): LengthAwarePaginator;
} 