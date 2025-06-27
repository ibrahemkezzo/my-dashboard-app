<?php

namespace App\Http\Controllers\Dashboard;

use App\Repositories\VisitRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Controller to handle updating time spent on a page.
 */
class VisitTimeController extends Controller
{
    /**
     * The visit repository instance.
     *
     * @var VisitRepository
     */
    protected VisitRepository $visitRepository;

    /**
     * Create a new controller instance.
     *
     * @param VisitRepository $visitRepository
     */
    public function __construct(VisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    /**
     * Update time spent for a visit.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateTime(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string',
            'page_url' => 'required|string',
            'time_spent' => 'required|integer|min:0',
        ]);

        $this->visitRepository->updateTimeSpent(
            $request->session_id,
            $request->page_url,
            $request->time_spent
        );

        return response()->json(['message' => 'Time updated successfully']);
    }
}
