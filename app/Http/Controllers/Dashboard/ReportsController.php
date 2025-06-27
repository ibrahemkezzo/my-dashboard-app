<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\AnalyticsInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Controller for handling visit reports.
 */
class ReportsController extends Controller
{
    /**
     * The analytics service instance.
     *
     * @var AnalyticsInterface
     */
    protected $analytics;

    /**
     * Create a new controller instance.
     *
     * @param AnalyticsInterface $analytics
     */
    public function __construct(AnalyticsInterface $analytics)
    {
        $this->middleware(['permission:view-reports']);
        $this->analytics = $analytics;
    }

    /**
     * Display the reports page.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $timeRange = $request->input('time_range', '7');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $deviceType = $request->input('device_type');
        $country = $request->input('country');

        $filters = [];

        if ($timeRange === 'custom' && $startDate && $endDate) {
            $filters['start_date'] = $startDate;
            $filters['end_date'] = $endDate;
        } elseif (is_numeric($timeRange)) {
            $filters['start_date'] = Carbon::now()->subDays((int)$timeRange)->startOfDay();
            $filters['end_date'] = Carbon::now()->endOfDay();
        }

        if ($deviceType) {
            $filters['device_type'] = $deviceType;
        }

        if ($country) {
            $filters['country'] = $country;
        }

        $days = $timeRange === 'custom' ? 30 : (int)$timeRange;

        return view('dashboard.reports', [
            'totalVisits' => $this->analytics->getTotalVisits($filters),
            'visitsByPage' => $this->analytics->getVisitsByPage($filters),
            'visitsByDevice' => $this->analytics->getVisitsByDevice($filters),
            'visitsByCountry' => $this->analytics->getVisitsByCountry($filters),
            'visitsByReferrer' => $this->analytics->getVisitsByReferrer($filters),
            'averageTimeSpent' => $this->analytics->getAverageTimeSpent($filters),
            'visitTrend' => $this->analytics->getVisitTrend($days, $filters),
            'countries' => $this->analytics->getCountries(),
            'timeRange' => $timeRange,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'deviceType' => $deviceType,
            'country' => $country,
        ]);
    }
    public function userActivityReport()
    {
        $sessions = \App\Models\Session::with(['user', 'visits'])
            ->orderByDesc('updated_at')
            ->paginate(30);
        // dd($sessions);

        return view('dashboard.user-activity-report', compact('sessions'));
    }
}