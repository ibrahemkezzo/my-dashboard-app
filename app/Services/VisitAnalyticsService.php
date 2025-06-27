<?php

namespace App\Services;

use App\Contracts\AnalyticsInterface;
use App\Repositories\VisitRepository;
use Illuminate\Support\Collection;

/**
 * Service for retrieving and analyzing visit statistics.
 */
class VisitAnalyticsService implements AnalyticsInterface
{
    /**
     * The visit repository instance.
     *
     * @var VisitRepository
     */
    protected VisitRepository $visitRepository;

    /**
     * Create a new service instance.
     *
     * @param VisitRepository $visitRepository
     */
    public function __construct(VisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    /**
     * @inheritdoc
     */
    public function getTotalVisits(array $filters = []): int
    {
        return $this->visitRepository->getTotalVisits($filters);
    }

    /**
     * @inheritdoc
     */
    public function getVisitsByPage(array $filters = []): array
    {
        return $this->visitRepository->getVisitsByPage($filters);
    }

    /**
     * @inheritdoc
     */
    public function getVisitsByDevice(array $filters = []): array
    {
        return $this->visitRepository->getVisitsByDevice($filters);
    }

    /**
     * @inheritdoc
     */
    public function getVisitsByCountry(array $filters = []): array
    {
        return $this->visitRepository->getVisitsByCountry($filters);
    }

    /**
     * @inheritdoc
     */
    public function getVisitsByReferrer(array $filters = []): array
    {
        return $this->visitRepository->getVisitsByReferrer($filters);
    }

    /**
     * @inheritdoc
     */
    public function getAverageTimeSpent(array $filters = []): array
    {
        return $this->visitRepository->getAverageTimeSpent($filters);
    }

    /**
     * @inheritdoc
     */
    public function getVisitTrend(int $days, array $filters = []): array
    {
        return $this->visitRepository->getVisitTrend($days, $filters);
    }

    /**
     * @inheritdoc
     */
    public function getCountries(): Collection
    {
        return $this->visitRepository->getCountries();
    }
}