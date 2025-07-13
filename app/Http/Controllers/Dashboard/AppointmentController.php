<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Salon;
use App\Services\AppointmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
        $this->middleware(['auth', 'role:super-admin']);
    }

    /**
     * Display a listing of appointments.
     */
    public function index(): View
    {
        $filters = request()->only(['search', 'status', 'payment_status', 'salon_id', 'user_id', 'date_from', 'date_to']);
        $appointments = $this->appointmentService->list(20, $filters);
        $statistics = $this->appointmentService->getStatistics($filters);
        
        $salons = Salon::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('dashboard.appointments.index', compact('appointments', 'statistics', 'salons', 'users', 'filters'));
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment): View
    {
        $appointment->load(['booking.user', 'booking.salon', 'booking.salonSubService.subService.service']);
        
        return view('dashboard.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment): View
    {
        $appointment->load(['booking.user', 'booking.salon', 'booking.salonSubService.subService.service']);
        
        return view('dashboard.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified appointment.
     */
    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $request->validate([
            'scheduled_datetime' => 'sometimes|required|date|after:now',
            'duration_minutes' => 'sometimes|required|integer|min:15|max:480',
            'total_price' => 'sometimes|required|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $this->appointmentService->update($appointment, $request->only([
                'scheduled_datetime', 'duration_minutes', 'total_price', 'deposit_amount', 'notes'
            ]));

            return redirect()->route('dashboard.appointments.show', $appointment)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.appointment_updated_successfully')]);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified appointment.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        try {
            $this->appointmentService->delete($appointment);

            return redirect()->route('dashboard.appointments.index')
                ->with('message', ['type' => 'success', 'content' => __('dashboard.appointment_deleted_successfully')]);
        } catch (\Exception $e) {
            return back()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Mark appointment as in progress.
     */
    public function markInProgress(Appointment $appointment): RedirectResponse
    {
        try {
            $this->appointmentService->markInProgress($appointment);

            return redirect()->route('dashboard.appointments.show', $appointment)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.appointment_marked_in_progress')]);
        } catch (\Exception $e) {
            return back()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Mark appointment as completed.
     */
    public function markCompleted(Request $request, Appointment $appointment): RedirectResponse
    {
        try {
            $notes = $request->input('notes');
            $this->appointmentService->markCompleted($appointment, $notes);

            return redirect()->route('dashboard.appointments.show', $appointment)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.appointment_marked_completed')]);
        } catch (\Exception $e) {
            return back()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Cancel an appointment.
     */
    public function cancel(Request $request, Appointment $appointment): RedirectResponse
    {
        try {
            $cancellationReason = $request->input('cancellation_reason');
            $this->appointmentService->cancelAppointment($appointment, $cancellationReason);

            return redirect()->route('dashboard.appointments.show', $appointment)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.appointment_cancelled_successfully')]);
        } catch (\Exception $e) {
            return back()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Mark appointment as no show.
     */
    public function markNoShow(Appointment $appointment): RedirectResponse
    {
        try {
            $this->appointmentService->markNoShow($appointment);

            return redirect()->route('dashboard.appointments.show', $appointment)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.appointment_marked_no_show')]);
        } catch (\Exception $e) {
            return back()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $request->validate([
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'amount_paid' => 'nullable|numeric|min:0',
        ]);

        try {
            $this->appointmentService->updatePaymentStatus(
                $appointment,
                $request->payment_status,
                $request->amount_paid
            );

            return redirect()->route('dashboard.appointments.show', $appointment)
                ->with('message', ['type' => 'success', 'content' => __('dashboard.payment_status_updated_successfully')]);
        } catch (\Exception $e) {
            return back()
                ->with('message', ['type' => 'error', 'content' => $e->getMessage()]);
        }
    }

    /**
     * Get appointments for a specific salon.
     */
    public function salonAppointments(Salon $salon): View
    {
        $filters = request()->only(['search', 'status', 'payment_status', 'user_id', 'date_from', 'date_to']);
        $filters['salon_id'] = $salon->id;
        
        $appointments = $this->appointmentService->getBySalon($salon, 20, $filters);
        $statistics = $this->appointmentService->getStatistics($filters);
        
        $users = User::orderBy('name')->get();

        return view('dashboard.appointments.salon', compact('appointments', 'statistics', 'salon', 'users', 'filters'));
    }

    /**
     * Get appointments for a specific user.
     */
    public function userAppointments(User $user): View
    {
        $filters = request()->only(['search', 'status', 'payment_status', 'date_from', 'date_to']);
        
        $appointments = $this->appointmentService->getByUser($user, 20, $filters);
        $statistics = $this->appointmentService->getStatistics(array_merge($filters, ['user_id' => $user->id]));

        return view('dashboard.appointments.user', compact('appointments', 'statistics', 'user', 'filters'));
    }

    /**
     * Get today's appointments.
     */
    public function today(): View
    {
        $filters = request()->only(['salon_id', 'status']);
        $appointments = $this->appointmentService->getTodayAppointments($filters);
        
        $salons = Salon::orderBy('name')->get();

        return view('dashboard.appointments.today', compact('appointments', 'salons', 'filters'));
    }

    /**
     * Get upcoming appointments.
     */
    public function upcoming(): View
    {
        $filters = request()->only(['salon_id', 'status']);
        $days = request()->input('days', 7);
        
        $appointments = $this->appointmentService->getUpcomingAppointments($days, $filters);
        
        $salons = Salon::orderBy('name')->get();

        return view('dashboard.appointments.upcoming', compact('appointments', 'salons', 'filters', 'days'));
    }

    /**
     * Get appointment calendar view.
     */
    public function calendar(): View
    {
        $filters = request()->only(['salon_id', 'month', 'year']);
        $month = $filters['month'] ?? now()->month;
        $year = $filters['year'] ?? now()->year;
        
        $salons = Salon::orderBy('name')->get();

        return view('dashboard.appointments.calendar', compact('salons', 'filters', 'month', 'year'));
    }
} 