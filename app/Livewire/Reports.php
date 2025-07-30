<?php

namespace App\Http\Livewire;

use App\Contracts\AnalyticsInterface;
use Carbon\Carbon;
use Livewire\Component;

/**
 * Livewire component for displaying dynamic visit reports.
 */
class Reports extends Component
{
    /**
     * The analytics service instance.
     *
     * @var AnalyticsInterface
     */
    protected $analytics;

    /**
     * Selected time range filter.
     *
     * @var string
     */
    public string $timeRange = '7';

    /**
     * Custom start date for filtering.
     *
     * @var string|null
     */
    public ?string $startDate = null;

    /**
     * Custom end date for filtering.
     *
     * @var string|null
     */
    public ?string $endDate = null;

    /**
     * Selected device type filter.
     *
     * @var string|null
     */
    public ?string $deviceType = null;

    /**
     * Selected country filter.
     *
     * @var string|null
     */
    public ?string $country = null;

    /**
     * Create a new component instance.
     *
     * @param AnalyticsInterface $analytics
     */
    public function __construct(AnalyticsInterface $analytics)
    {
        dd(5);
        parent::__construct();
        $this->analytics = $analytics;
    }

    /**
     * Update the component when filters change.
     *
     * @param string $property
     */
    public function updated($property): void
    {
        if (in_array($property, ['timeRange', 'startDate', 'endDate', 'deviceType', 'country'])) {
            $this->emit('updateChart');
        }
    }

    /**
     * Get filters for analytics queries.
     *
     * @return array
     */
    protected function getFilters(): array
    {
        $filters = [];

        if ($this->timeRange === 'custom' && $this->startDate && $this->endDate) {
            $filters['start_date'] = $this->startDate;
            $filters['end_date'] = $this->endDate;
        } elseif (is_numeric($this->timeRange)) {
            $filters['start_date'] = Carbon::now()->subDays((int)$this->timeRange)->startOfDay();
        }

        if ($this->deviceType) {
            $filters['device_type'] = $this->deviceType;
        }

        if ($this->country) {
            $filters['country'] = $this->country;
        }

        return $filters;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        dd(5);
        $filters = $this->getFilters();
        $days = $this->timeRange === 'custom' ? 30 : (int)$this->timeRange;

        return view('livewire.reports', [
            'totalVisits' => $this->analytics->getTotalVisits($filters),
            'visitsByPage' => $this->analytics->getVisitsByPage($filters),
            'visitsByDevice' => $this->analytics->getVisitsByDevice($filters),
            'visitsByCountry' => $this->analytics->getVisitsByCountry($filters),
            'visitsByReferrer' => $this->analytics->getVisitsByReferrer($filters),
            'averageTimeSpent' => $this->analytics->getAverageTimeSpent($filters),
            'visitTrend' => $this->analytics->getVisitTrend($days, $filters),
            'countries' => $this->analytics->getCountries(),
        ]);
    }
}