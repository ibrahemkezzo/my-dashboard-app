<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Models\Salon;
use App\Models\Booking;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct(
        private RatingService $ratingService
    ) {}

    /**
     * Show the rating form for a specific salon.
     */
    public function create(Salon $salon)
    {
        $user = Auth::user();

        // Must have at least one completed booking
        $hasCompleted = $user->bookings()->where('salon_id', $salon->id)->where('status', 'completed')->exists();
        if (!$hasCompleted) {
            return redirect()->route('front.salons.show', $salon)->with('error', 'You must complete a booking before rating this salon.');
        }

        $existingRating = $user->ratings()->where('salon_id', $salon->id)->first();

        return view('frontend.rating.rating', [
            'salon' => $salon,
            'existingRating' => $existingRating,
        ]);
    }

    /**
     * Store a new rating.
     */
    public function store(StoreRatingRequest $request, Salon $salon)
    {
        $user = Auth::user();
        // Prevent multi-submission
        $request->session()->regenerateToken();

        try {
            $this->ratingService->saveRating($user, $salon, [
                'rating' => (int) $request->input('rating'),
                'review' => $request->input('review'),
            ]);

            return redirect()->route('front.salons.show', $salon)
                ->with('message', ['type' => 'success', 'content' => 'تم إرسال تقييمك وهو قيد المراجعة']);
        } catch (\Exception $e) {
            return redirect()->route('front.salons.show', $salon)
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Show user's ratings.
     */
    public function myRatings(Request $request)
    {
        $user = Auth::user();
        $ratings = $this->ratingService->getUserRatings($user, 15, $request->all());

        return view('frontend.rating.my-ratings', compact('ratings'));
    }

    /**
     * Show ratings for a specific salon.
     */
    public function salonRatings(Salon $salon, Request $request)
    {
        $ratings = $this->ratingService->getSalonRatings($salon, 15, $request->all());
        $statistics = $this->ratingService->getSalonRatingStatistics($salon);

        return view('frontend.rating.salon-ratings', compact('salon', 'ratings', 'statistics'));
    }
}
