<?php

namespace App\Contracts;

/**
 * Interface for analytics services to retrieve visit statistics.
 */
interface AnalyticsInterface
{
    /**
     * Get total number of visits.
     *
     * @param array $filters
     * @return int
     */
    public function getTotalVisits(array $filters = []): int;

    /**
     * Get visits grouped by page.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByPage(array $filters = []): array;

    /**
     * Get visits grouped by device type.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByDevice(array $filters = []): array;

    /**
     * Get visits grouped by country.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByCountry(array $filters = []): array;

    /**
     * Get visits grouped by referrer.
     *
     * @param array $filters
     * @return array
     */
    public function getVisitsByReferrer(array $filters = []): array;

    /**
     * Get average time spent per page.
     *
     * @param array $filters
     * @return array
     */
    public function getAverageTimeSpent(array $filters = []): array;

    /**
     * Get visit trend over a period.
     *
     * @param int $days
     * @param array $filters
     * @return array
     */
    public function getVisitTrend(int $days, array $filters = []): array;

    /**
     * Get list of unique countries.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCountries(): \Illuminate\Support\Collection;
}