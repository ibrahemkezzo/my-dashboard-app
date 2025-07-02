<?php

namespace App\Services;

use App\Contracts\UserActivityInterface;
use App\Contracts\VisitRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Service for handling user activity-related business logic.
 */
class UserActivityService implements UserActivityInterface
{
    /**
     * The visit repository instance.
     *
     * @var VisitRepositoryInterface
     */
    protected VisitRepositoryInterface $visitRepository;

    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * Create a new service instance.
     *
     * @param VisitRepositoryInterface $visitRepository
     * @param UserRepository $userRepository
     */
    public function __construct(VisitRepositoryInterface $visitRepository, UserRepository $userRepository)
    {
        $this->visitRepository = $visitRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get user activity data including sessions and statistics.
     *
     * @param int $userId
     * @param int $perPage
     * @return array
     */
    public function getUserActivityData(int $userId, int $perPage = 10): array
    {
        $user = $this->userRepository->findUser($userId);

        // Get paginated sessions with visits
        $sessions = $this->visitRepository->getUserSessions($userId, $perPage);

        // // Get user visits with session details
        // $visits = $this->visitRepository->getUserVisitsWithSessions($userId, $perPage);

        // // Get user visits grouped by page
        // $visitsByPage = $this->visitRepository->getUserVisitsByPage($userId);

        // Get activity statistics
        $statistics = $this->getUserActivityStatistics($userId);

        return [
            'user' => $user,
            'sessions' => $sessions,
            'statistics' => $statistics,
        ];
    }

    /**
     * Get user activity statistics.
     *
     * @param int $userId
     * @return array
     */
    public function getUserActivityStatistics(int $userId): array
    {
        $totalSessions = $this->visitRepository->getUserSessionsCount($userId);
        $totalVisits = $this->visitRepository->getUserVisitsCount($userId);
        $lastSession = $this->visitRepository->getUserLastSession($userId);
        $deviceTypesCount = $this->visitRepository->getUserDeviceTypesCount($userId);

        return [
            'total_sessions' => $totalSessions,
            'total_visits' => $totalVisits,
            'last_session' => $lastSession,
            'device_types_count' => $deviceTypesCount,
        ];
    }

    /**
     * Get user sessions with pagination.
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserSessions(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->visitRepository->getUserSessions($userId, $perPage);
    }

    /**
     * Get user visits by session.
     *
     * @param string $sessionId
     * @return Collection
     */
    public function getUserVisitsBySession(string $sessionId): Collection
    {
        return $this->visitRepository->getVisitsBySession($sessionId);
    }

    /**
     * Get user visits with session details.
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserVisitsWithSessions(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->visitRepository->getUserVisitsWithSessions($userId, $perPage);
    }

    /**
     * Get user visits grouped by page.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserVisitsByPage(int $userId): Collection
    {
        return $this->visitRepository->getUserVisitsByPage($userId);
    }
}