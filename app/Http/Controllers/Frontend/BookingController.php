<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Salon;
use App\Models\SalonSubService;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->middleware(['auth']);
        $this->bookingService = $bookingService;
    }

    // List all bookings for the authenticated user
    public function bookings(Request $request)
    {
        $user = Auth::user();
        $filters = $request->only(['status', 'date_from', 'date_to']);
        $bookings = $this->bookingService->getByUser($user, 100, $filters); // Large enough for all
        return view('frontend.profile.bookings', compact('bookings'));
    }

    // Show create booking form
    // public function create()
    // {
    //     $user = Auth::user();
    //     $salons = Salon::where('status', true)->orderBy('name')->get();
    //     $salonSubServices = SalonSubService::with(['salon', 'subService.service'])
    //         ->where('status', true)
    //         ->get()
    //         ->groupBy('salon_id');
    //     return view('frontend.profile.booking_create', compact('salons', 'salonSubServices'));
    // }

    // Store new booking
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $data = $request->validate([
            'salon_id' => ['required', 'exists:salons,id'],
            'salon_sub_service_id' => ['required', 'exists:salon_sub_service,id'],
            'service_description' => ['required', 'string', 'min:10', 'max:1000'],
            'preferred_datetime' => ['required', 'date', 'after:now'],
        ]);
        // dd($data);
        $data['user_id'] = $user->id;
        $this->bookingService->create($data);
        return redirect()->route('front.profile.bookings')->with('message', ['type' => 'success', 'content' => __('تم إنشاء الحجز بنجاح')]);
    }

    // Show edit form for a booking
    public function edit(Booking $booking)
    {
        $user = Auth::user();
        if ($booking->user_id !== $user->id) abort(403);
        $salons = Salon::where('status', true)->orderBy('name')->get();
        $salonSubServices = SalonSubService::with(['salon', 'subService.service'])
            ->where('status', true)
            ->get()
            ->groupBy('salon_id');
        return view('frontend.profile.booking_edit', compact('booking', 'salons', 'salonSubServices'));
    }

    // Update a booking
    public function update(Request $request, Booking $booking)
    {
        $user = Auth::user();
        if ($booking->user_id !== $user->id) abort(403);
        $data = $request->validate([
            'salon_id' => ['required', 'exists:salons,id'],
            'salon_sub_service_id' => ['required', 'exists:salon_sub_service,id'],
            'service_description' => ['required', 'string', 'min:10', 'max:1000'],
            'preferred_datetime' => ['required', 'date', 'after:now'],
        ]);
        $this->bookingService->update($booking, $data);
        return redirect()->route('front.profile.bookings')->with('message', ['type' => 'success', 'content' => __('تم تحديث الحجز بنجاح')]);
    }

    // Cancel a booking
    public function cancel(Request $request, Booking $booking)
    {
        $user = Auth::user();
        if ($booking->user_id !== $user->id) abort(403);
        $this->bookingService->cancelBooking($booking, $request->input('cancellation_reason'));
        return redirect()->route('front.profile.bookings')->with('message', ['type' => 'success', 'content' => __('تم إلغاء الحجز بنجاح')]);
    }

    // Confirm or reject a salon's proposal
    public function confirm(Request $request, Booking $booking)
    {
        $user = Auth::user();
        if ($booking->user_id !== $user->id) abort(403);
        $data = $request->validate([
            'action' => 'required|in:confirm,reject',
            'user_notes' => 'nullable|string|max:500',
        ]);
        $this->bookingService->userConfirmBooking($booking, $data);
        return redirect()->route('front.profile.bookings')->with('message', ['type' => 'success', 'content' => __('تم تحديث حالة الحجز')]);
    }

    public function completed(Booking $booking){
        try {
            $this->bookingService->markBookingCompleted($booking);
            return redirect()->route('front.profile.bookings')->with('message', ['type' => 'success', 'content' => __('تم تحديث حالة الحجز')]);
        } catch (\Exception $e) {
            // dd($e);
            return back()->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }
}
