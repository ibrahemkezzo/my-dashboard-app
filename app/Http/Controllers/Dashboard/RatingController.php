<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct(
        private RatingService $ratingService
    ) {}

    /**
     * Display a listing of ratings.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'salon_id', 'user_id', 'rating']);
        $ratings = $this->ratingService->getAllRatings(15, $filters);
        $pendingCount = $this->ratingService->getPendingRatingsCount();

        return view('dashboard.ratings.index', compact('ratings', 'pendingCount', 'filters'));
    }

    /**
     * Show the form for editing the specified rating.
     */
    public function edit(Rating $rating)
    {
        return view('dashboard.ratings.edit', compact('rating'));
    }

    /**
     * Update the specified rating.
     */
    public function update(Request $request, Rating $rating)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        try {
            $this->ratingService->updateRating($rating, $request->only(['rating', 'review', 'status']));

            return redirect()->route('dashboard.ratings.index')
                ->with('success', 'Rating updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Approve a rating.
     */
    public function approve(Rating $rating)
    {
        try {
            $this->ratingService->approveRating($rating);

            return redirect()->route('dashboard.ratings.index')
                ->with('success', 'Rating approved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Reject a rating.
     */
    public function reject(Request $request, Rating $rating)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:255',
        ]);

        try {
            $this->ratingService->rejectRating($rating, $request->rejection_reason);

            return redirect()->route('dashboard.ratings.index')
                ->with('success', 'Rating rejected successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified rating.
     */
    public function destroy(Rating $rating)
    {
        try {
            $this->ratingService->deleteRating($rating);

            return redirect()->route('dashboard.ratings.index')
                ->with('success', 'Rating deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show rating statistics.
     */
    public function statistics()
    {
        $recentRatings = $this->ratingService->getRecentRatings(10);
        $pendingCount = $this->ratingService->getPendingRatingsCount();

        return view('dashboard.ratings.statistics', compact('recentRatings', 'pendingCount'));
    }
}
