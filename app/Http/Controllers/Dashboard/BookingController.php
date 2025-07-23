<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Requests\SalonConfirmBookingRequest;
use App\Http\Requests\UserConfirmBookingRequest;
use App\Http\Requests\RejectBookingRequest;
use App\Models\Booking;
use App\Models\User;
use App\Models\Salon;
use App\Models\SalonSubService;
use App\Services\BookingService;
use App\Services\AppointmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;
    protected $appointmentService;

    public function __construct(BookingService $bookingService, AppointmentService $appointmentService)
    {
        $this->bookingService = $bookingService;
        $this->appointmentService = $appointmentService;
        $this->middleware(['auth', 'role:super-admin']);
    }

    /**
     * Display a listing of bookings.
     */
    public function index(): View
    {
        $filters = request()->only(['search', 'status', 'salon_id', 'user_id', 'date_from', 'date_to']);
        $bookings = $this->bookingService->list(20, $filters);
        $statistics = $this->bookingService->getStatistics($filters);

        $salons = Salon::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('dashboard.bookings.index', compact('bookings', 'statistics', 'salons', 'users', 'filters'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(): View
    {
        $users = User::where('is_active', true)->orderBy('name')->get();
        $salons = Salon::where('status', true)->orderBy('name')->get();
        $salonSubServices = SalonSubService::with(['salon', 'subService.service'])
            ->where('status', true)
            ->get()
            ->groupBy('salon_id');

        return view('dashboard.bookings.create', compact('users', 'salons', 'salonSubServices'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        try {
            $this->bookingService->create($request->validated());

            return redirect()->route('dashboard.bookings.index')
                ->with('message', ['type' => 'success', 'content' => __('dashboard.booking_created_successfully')]);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking): View
    {
        $booking->load(['user', 'salon', 'salonSubService.subService.service', 'appointment']);

        return view('dashboard.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking): View
    {
        $booking->load(['user', 'salon', 'salonSubService.subService.service']);

        $users = User::where('is_active', true)->orderBy('name')->get();
        $salons = Salon::where('status', true)->orderBy('name')->get();
        $salonSubServices = SalonSubService::with(['salon', 'subService.service'])
            ->where('status', true)
            ->get()
            ->groupBy('salon_id');

        return view('dashboard.bookings.edit', compact('booking', 'users', 'salons', 'salonSubServices'));
    }

    /**
     * Update the specified booking.
     */
    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->update($booking, $request->validated());

            return redirect()->route('dashboard.bookings.index')
                ->with('message', ['type' => 'success', 'content' => __('dashboard.booking_updated_successfully')]);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->delete($booking);

            return redirect()->route('dashboard.bookings.index')
                ->with('message', ['type' => 'success', 'content' => __('dashboard.booking_deleted_successfully')]);
        } catch (\Exception $e) {
            return back()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for salon to confirm/modify a booking.
     */
    public function salonConfirmForm(Booking $booking)
    {
        if (!$booking->canBeConfirmedBySalon()) {
            return redirect()->route('dashboard.bookings.show', $booking)
                ->with('message', ['type' => 'error', 'content' => __('dashboard.booking_cannot_be_confirmed_by_salon')]);
        }

        $booking->load(['user', 'salon', 'salonSubService.subService.service']);

        // Get available time slots for the preferred date
        $preferredDate = $booking->preferred_datetime->format('Y-m-d');
        $durationMinutes = $booking->salonSubService->duration ?? 60;
        // dd($durationMinutes,$booking->salonSubService);
        // $availableSlots = $this->appointmentService->getAvailableTimeSlots(
        //     $booking->salon_id,
        //     $preferredDate,
        //     $durationMinutes
        // );
        // dd($availableSlots);
        return view('dashboard.bookings.salon_confirm', compact('booking',  'durationMinutes'));
    }

    /**
     * Salon confirms or modifies a booking.
     */
    public function salonConfirm(SalonConfirmBookingRequest $request, Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->salonConfirmBooking($booking, $request->validated());

            return redirect()->route('dashboard.bookings.show', $booking)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.booking_confirmed_by_salon_successfully')]);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for user to confirm salon's response.
     */
    public function userConfirmForm(Booking $booking)
    {
        if (!$booking->canBeConfirmedByUser()) {
            return redirect()->route('dashboard.bookings.show', $booking)
                ->with('message', ['type' => 'error', 'content' => __('dashboard.booking_cannot_be_confirmed_by_user')]);
        }

        $booking->load(['user', 'salon', 'salonSubService.subService.service']);

        return view('dashboard.bookings.user_confirm', compact('booking'));
    }

    /**
     * User confirms salon's response and creates appointment.
     */
    public function userConfirm(UserConfirmBookingRequest $request, Booking $booking): RedirectResponse
    {
        try {
            $result = $this->bookingService->userConfirmBooking($booking, $request->validated());
            // Remove appointment creation logic
            return redirect()->route('dashboard.bookings.show', $booking)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.booking_confirmed_by_user_successfully')]);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for rejecting a booking.
     */
    public function rejectForm(Booking $booking)
    {
        if (!$booking->canBeRejected()) {
            return redirect()->route('dashboard.bookings.show', $booking)
                ->with('message', ['type' => 'error', 'content' => __('dashboard.booking_cannot_be_rejected')]);
        }

        return view('dashboard.bookings.reject', compact('booking'));
    }

    /**
     * Reject a booking.
     */
    public function reject(RejectBookingRequest $request, Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->rejectBooking($booking, $request->validated('rejection_reason'));

            return redirect()->route('dashboard.bookings.show', $booking)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.booking_rejected_successfully')]);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        try {
            $cancellationReason = $request->input('cancellation_reason');
            $this->bookingService->cancelBooking($booking, $cancellationReason);

            return redirect()->route('dashboard.bookings.show', $booking)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.booking_cancelled_successfully')]);
        } catch (\Exception $e) {
            return back()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Mark a booking as completed.
     */
    public function complete(Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->markBookingCompleted($booking);
            return redirect()->route('dashboard.bookings.show', $booking)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.booking_marked_completed_successfully')]);
        } catch (\Exception $e) {
            // dd($e);
            return back()->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Get bookings for a specific salon.
     */
    public function salonBookings(Salon $salon): View
    {
        $filters = request()->only(['search', 'status', 'user_id', 'date_from', 'date_to']);
        $filters['salon_id'] = $salon->id;

        $bookings = $this->bookingService->getBySalon($salon, 20, $filters);
        $statistics = $this->bookingService->getStatistics($filters);

        $users = User::orderBy('name')->get();

        return view('dashboard.bookings.salon', compact('bookings', 'statistics', 'salon', 'users', 'filters'));
    }

    /**
     * Get bookings for a specific user.
     */
    public function userBookings(User $user): View
    {
        $filters = request()->only(['search', 'status', 'date_from', 'date_to']);

        $bookings = $this->bookingService->getByUser($user, 20, $filters);
        $statistics = $this->bookingService->getStatistics(array_merge($filters, ['user_id' => $user->id]));

        return view('dashboard.bookings.user', compact('bookings', 'statistics', 'user', 'filters'));
    }

    /**
     * Get available time slots for a salon on a specific date.
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'salon_id' => 'required|exists:salons,id',
            'date' => 'required|date|after_or_equal:today',
            'duration_minutes' => 'nullable|integer|min:15|max:480',
        ]);

        $slots = $this->appointmentService->getAvailableTimeSlots(
            $request->salon_id,
            $request->date,
            $request->duration_minutes ?? 60
        );

        return response()->json($slots);
    }
}