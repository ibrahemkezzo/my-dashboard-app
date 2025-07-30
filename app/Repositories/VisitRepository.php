<?php

namespace App\Repositories;

use App\Contracts\VisitRepositoryInterface;
use App\Models\Session;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Repository for managing website visit data.
 */
class VisitRepository implements VisitRepositoryInterface
{
    /**
     * Record a new session.
     *
     * @param array $data Session data including session_id, device_type, country, referrer.
     * @return void
     */
    public function recordSession(array $data): void
    {
        Session::create([
            'session_id' => $data['session_id'],
            'device_type' => $data['device_type'],
            'country' => $data['country'],
            'referrer' => $data['referrer'],
            'started_at' => now(),
        ]);
    }

    /**
     * Record a new visit.
     *
     * @param array $data Visit data including session_id, page_url.
     * @return void
     */
    public function recordVisit(array $data): void
    {
        Visit::create([
            'session_id' => $data['session_id'],
            'page_url' => $data['page_url'],
            'visited_at' => now(),
        ]);
    }

    /**
     * Update time spent for a visit.
     *
     * @param string $sessionId
     * @param string $pageUrl
     * @param int $timeSpent
     * @return void
     */
    public function updateTimeSpent(string $sessionId, string $pageUrl, int $timeSpent): void
    {
        Visit::where('session_id', $sessionId)
            ->where('page_url', $pageUrl)
            ->latest('visited_at')
            ->first()
            ?->update(['time_spent' => $timeSpent]);
    }

    /**
     * Get total number of visits with optional filters.
     *
     * @param array $filters
     * @return int
     */
    public function getTotalVisits(array $filters = []): int
    {
        return $this->applyFilters(Visit::query(), $filters)->count();
    }

    /**
     * Get visits grouped by page with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByPage(array $filters = []): array
    {
        return $this->applyFilters(Visit::query(), $filters)
            ->groupBy('page_url')
            ->selectRaw('page_url, COUNT(*) as visit_count')
            ->orderByDesc('visit_count')
            ->get()
            ->toArray();
    }

    /**
     * Get visits grouped by device type with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByDevice(array $filters = []): array
    {
        return $this->applyFilters(Visit::query()->join('sessions', 'visits.session_id', '=', 'sessions.session_id'), $filters)
            ->groupBy('sessions.device_type')
            ->selectRaw('sessions.device_type, COUNT(*) as visit_count')
            ->get()
            ->toArray();
    }

    /**
     * Get visits grouped by country with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByCountry(array $filters = []): array
    {
        return $this->applyFilters(Visit::query()->join('sessions', 'visits.session_id', '=', 'sessions.session_id'), $filters)
            ->groupBy('sessions.country')
            ->selectRaw('sessions.country, COUNT(*) as visit_count')
            ->get()
            ->toArray();
    }

    /**
     * Get visits grouped by referrer with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByReferrer(array $filters = []): array
    {
        return $this->applyFilters(Visit::query()->join('sessions', 'visits.session_id', '=', 'sessions.session_id'), $filters)
            ->groupBy('sessions.referrer')
            ->selectRaw('sessions.referrer, COUNT(*) as visit_count')
            ->get()
            ->toArray();
    }

    /**
     * Get average time spent per page with optional filters.
     *
     * @param array $filters
     * @return array
     */
    public function getAverageTimeSpent(array $filters = []): array
    {
        return $this->applyFilters(Visit::query(), $filters)
            ->groupBy('page_url')
            ->selectRaw('page_url, AVG(time_spent) as avg_time_spent')
            ->get()
            ->toArray();
    }

    /**
     * Get visit trend over a period with optional filters.
     *
     * @param int $days
     * @param array $filters
     * @return array
     */
    public function getVisitTrend(int $days, array $filters = []): array
    {
        return $this->applyFilters(Visit::query(), $filters)
            ->where('visited_at', '>=', Carbon::now()->subDays($days))
            ->groupByRaw('DATE(visited_at)')
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as visit_count')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    /**
     * Get list of unique countries for filtering.
     *
     * @return Collection
     */
    public function getCountries(): Collection
    {
        return Session::select('country')->distinct()->whereNotNull('country')->pluck('country');
    }

    /**
     * Get user sessions with visits.
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserSessions(int $userId, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Session::where('user_id', $userId)
            ->with(['visits' => function($query) {
                $query->orderBy('visited_at', 'desc');
            }])
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get user sessions count.
     *
     * @param int $userId
     * @return int
     */
    public function getUserSessionsCount(int $userId): int
    {
        return Session::where('user_id', $userId)->count();
    }

    /**
     * Get user visits count.
     *
     * @param int $userId
     * @return int
     */
    public function getUserVisitsCount(int $userId): int
    {
        return Visit::whereHas('session', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();
    }

    /**
     * Get user last session.
     *
     * @param int $userId
     * @return \App\Models\Session|null
     */
    public function getUserLastSession(int $userId): ?\App\Models\Session
    {
        return Session::where('user_id', $userId)->latest()->first();
    }

    /**
     * Get user device types count.
     *
     * @param int $userId
     * @return int
     */
    public function getUserDeviceTypesCount(int $userId): int
    {
        return Session::where('user_id', $userId)->distinct('device_type')->count();
    }

    /**
     * Get visits by session ID.
     *
     * @param string $sessionId
     * @return Collection
     */
    public function getVisitsBySession(string $sessionId): Collection
    {
        return Visit::where('session_id', $sessionId)
            ->orderBy('visited_at', 'desc')
            ->get();
    }

    /**
     * Get all visits for a specific user.
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserVisits(int $userId, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Visit::whereHas('session', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['session' => function($query) {
            $query->select('session_id', 'user_id', 'device_type', 'country', 'started_at', 'updated_at');
        }])
        ->orderBy('visited_at', 'desc')
        ->paginate($perPage);
    }

    /**
     * Get user visits grouped by page with visit count.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserVisitsByPage(int $userId): Collection
    {
        return Visit::whereHas('session', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->selectRaw('page_url, COUNT(*) as visit_count, MAX(visited_at) as last_visited')
        ->groupBy('page_url')
        ->orderByDesc('visit_count')
        ->get();
    }
    /**
     * Get user visits with session details.
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserVisitsWithSessions(int $userId, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        // $sessionsId[] = 
        return Visit::whereHas('session', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['session' => function($query) {
            $query->select('session_id', 'user_id', 'device_type', 'country', 'started_at', 'updated_at');
        }])
        ->orderBy('visited_at', 'desc')
        ->paginate($perPage);
    }

    /**
     * Apply filters to a query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilters($query, array $filters)
    {
        if (!empty($filters['start_date'])) {
            $query->where('visited_at', '>=', Carbon::parse($filters['start_date']));
        }
        if (!empty($filters['end_date'])) {
            $query->where('visited_at', '<=', Carbon::parse($filters['end_date']));
        }
        if (!empty($filters['device_type'])) {
            $query->whereHas('session', function ($q) use ($filters) {
                $q->where('device_type', $filters['device_type']);
            });
        }
        if (!empty($filters['country'])) {
            $query->whereHas('session', function ($q) use ($filters) {
                $q->where('country', $filters['country']);
            });
        }

        return $query;
    }
}
