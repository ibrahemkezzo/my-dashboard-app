<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Booking;
use App\Models\User;
use App\Models\Salon;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AppointmentService
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    /**
     * Get all appointments with pagination and filters.
     */
    public function list($perPage = 15, $filters = [])
    {
        return $this->appointmentRepository->paginate($perPage, $filters);
    }

    /**
     * Get all appointments.
     */
    public function all()
    {
        return $this->appointmentRepository->all();
    }

    /**
     * Find an appointment by ID.
     */
    public function find($id)
    {
        return $this->appointmentRepository->find($id);
    }

    /**
     * Find an appointment by appointment number.
     */
    public function findByAppointmentNumber($appointmentNumber)
    {
        return $this->appointmentRepository->findByAppointmentNumber($appointmentNumber);
    }

    /**
     * Create a new appointment.
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Validate that the booking exists and is confirmed
            $booking = Booking::find($data['booking_id'] ?? null);
            if (!$booking || $booking->status !== 'confirmed') {
                throw new \Exception('Invalid booking or booking is not confirmed.');
            }

            // Check for scheduling conflicts
            $scheduledDatetime = Carbon::parse($data['scheduled_datetime']);
            $durationMinutes = $data['duration_minutes'] ?? 60;

            if ($this->appointmentRepository->checkConflicts(
                $booking->salon_id,
                $scheduledDatetime,
                $durationMinutes
            )) {
                throw new \Exception('There is a scheduling conflict for the selected time.');
            }

            // Create the appointment
            $appointment = $this->appointmentRepository->create($data);

            Log::info('New appointment created', [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
                'booking_id' => $appointment->booking_id,
                'scheduled_datetime' => $appointment->scheduled_datetime,
            ]);

            return $appointment;
        });
    }

    /**
     * Update an appointment.
     */
    public function update(Appointment $appointment, array $data)
    {
        return DB::transaction(function () use ($appointment, $data) {
            // If updating scheduled datetime, check for conflicts
            if (isset($data['scheduled_datetime'])) {
                $scheduledDatetime = Carbon::parse($data['scheduled_datetime']);
                $durationMinutes = $data['duration_minutes'] ?? $appointment->duration_minutes;

                if ($this->appointmentRepository->checkConflicts(
                    $appointment->booking->salon_id,
                    $scheduledDatetime,
                    $durationMinutes,
                    $appointment->id
                )) {
                    throw new \Exception('There is a scheduling conflict for the selected time.');
                }
            }

            $appointment = $this->appointmentRepository->update($appointment, $data);

            Log::info('Appointment updated', [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
                'updated_fields' => array_keys($data),
            ]);

            return $appointment;
        });
    }

    /**
     * Delete an appointment.
     */
    public function delete(Appointment $appointment)
    {
        return DB::transaction(function () use ($appointment) {
            // Check if appointment can be deleted
            if (in_array($appointment->status, ['in_progress', 'completed'])) {
                throw new \Exception('Cannot delete appointment that is in progress or completed.');
            }

            $result = $this->appointmentRepository->delete($appointment);

            Log::info('Appointment deleted', [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
            ]);

            return $result;
        });
    }

    /**
     * Mark appointment as in progress.
     */
    public function markInProgress(Appointment $appointment)
    {
        return DB::transaction(function () use ($appointment) {
            if (!$appointment->canBeInProgress()) {
                throw new \Exception('Appointment cannot be marked as in progress.');
            }

            $appointment = $this->appointmentRepository->update($appointment, [
                'status' => 'in_progress',
            ]);

            Log::info('Appointment marked as in progress', [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
            ]);

            return $appointment;
        });
    }

    /**
     * Mark appointment as completed.
     */
    public function markCompleted(Appointment $appointment, $notes = null)
    {
        return DB::transaction(function () use ($appointment, $notes) {
            if (!$appointment->canBeCompleted()) {
                throw new \Exception('Appointment cannot be marked as completed.');
            }

            $updateData = ['status' => 'completed'];
            if ($notes) {
                $updateData['notes'] = $notes;
            }

            $appointment = $this->appointmentRepository->update($appointment, $updateData);

            Log::info('Appointment marked as completed', [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
            ]);

            return $appointment;
        });
    }

    /**
     * Cancel an appointment.
     */
    public function cancelAppointment(Appointment $appointment, $cancellationReason = null)
    {
        return DB::transaction(function () use ($appointment, $cancellationReason) {
            if (!$appointment->canBeCancelled()) {
                throw new \Exception('Appointment cannot be cancelled.');
            }

            $appointment = $this->appointmentRepository->update($appointment, [
                'status' => 'cancelled',
                'cancellation_reason' => $cancellationReason,
                'cancelled_at' => now(),
            ]);

            Log::info('Appointment cancelled', [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
                'cancellation_reason' => $cancellationReason,
            ]);

            return $appointment;
        });
    }

    /**
     * Mark appointment as no show.
     */
    public function markNoShow(Appointment $appointment)
    {
        return DB::transaction(function () use ($appointment) {
            if (!in_array($appointment->status, ['scheduled', 'in_progress'])) {
                throw new \Exception('Appointment cannot be marked as no show.');
            }

            $appointment = $this->appointmentRepository->update($appointment, [
                'status' => 'no_show',
            ]);

            Log::info('Appointment marked as no show', [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
            ]);

            return $appointment;
        });
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Appointment $appointment, $paymentStatus, $amountPaid = null)
    {
        return DB::transaction(function () use ($appointment, $paymentStatus, $amountPaid) {
            $updateData = ['payment_status' => $paymentStatus];

            if ($amountPaid !== null) {
                $updateData['deposit_paid'] = $amountPaid;
            }

            $appointment = $this->appointmentRepository->update($appointment, $updateData);

            Log::info('Appointment payment status updated', [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
                'payment_status' => $paymentStatus,
                'amount_paid' => $amountPaid,
            ]);

            return $appointment;
        });
    }

    /**
     * Get appointments for a specific user.
     */
    public function getByUser(User $user, $perPage = 15, $filters = [])
    {
        return $this->appointmentRepository->getByUser($user, $perPage, $filters);
    }

    /**
     * Get appointments for a specific salon.
     */
    public function getBySalon(Salon $salon, $perPage = 15, $filters = [])
    {
        return $this->appointmentRepository->getBySalon($salon, $perPage, $filters);
    }

    /**
     * Get appointments for a specific booking.
     */
    public function getByBooking(Booking $booking)
    {
        return $this->appointmentRepository->getByBooking($booking);
    }

    /**
     * Get today's appointments.
     */
    public function getTodayAppointments($filters = [])
    {
        return $this->appointmentRepository->getTodayAppointments($filters);
    }

    /**
     * Get upcoming appointments.
     */
    public function getUpcomingAppointments($days = 7, $filters = [])
    {
        return $this->appointmentRepository->getUpcomingAppointments($days, $filters);
    }

    /**
     * Get appointment statistics.
     */
    public function getStatistics($filters = [])
    {
        return $this->appointmentRepository->getStatistics($filters);
    }

    /**
     * Check for scheduling conflicts.
     */
    public function checkConflicts($salonId, $scheduledDatetime, $durationMinutes, $excludeAppointmentId = null)
    {
        return $this->appointmentRepository->checkConflicts(
            $salonId,
            $scheduledDatetime,
            $durationMinutes,
            $excludeAppointmentId
        );
    }

    /**
     * Get available time slots for a salon on a specific date.
     */
    public function getAvailableTimeSlots($salonId, $date, $durationMinutes = 60)
    {
        $date = Carbon::parse($date);
        $startTime = $date->copy()->setTime(9, 0); // Salon opens at 9 AM
        $endTime = $date->copy()->setTime(18, 0); // Salon closes at 6 PM
        $timeSlots = [];
        // dd($durationMinutes);
        // Generate time slots every 30 minutes
        $currentTime = $startTime->copy();
        while ($currentTime->addMinutes($durationMinutes) <= $endTime) {
            $slotStart = $currentTime->copy()->subMinutes($durationMinutes);
            $slotEnd = $currentTime->copy();

            // Check if this time slot is available
            if (!$this->checkConflicts($salonId, $slotStart, $durationMinutes)) {
                $timeSlots[] = [
                    'start_time' => $slotStart->format('H:i'),
                    'end_time' => $slotEnd->format('H:i'),
                    'datetime' => $slotStart->format('Y-m-d H:i:s'),
                ];
            }
        }

        return $timeSlots;
    }

    /**
     * Validate appointment data.
     */
    public function validateAppointmentData(array $data): array
    {
        $errors = [];

        // Check if booking exists and is confirmed
        $booking = Booking::find($data['booking_id'] ?? null);
        if (!$booking || $booking->status !== 'confirmed') {
            $errors[] = 'Invalid booking or booking is not confirmed.';
        }

        // Validate scheduled datetime
        if (isset($data['scheduled_datetime'])) {
            $scheduledDatetime = Carbon::parse($data['scheduled_datetime']);
            if ($scheduledDatetime->isPast()) {
                $errors[] = 'Scheduled appointment time must be in the future.';
            }
        }

        // Validate duration
        if (isset($data['duration_minutes']) && $data['duration_minutes'] <= 0) {
            $errors[] = 'Duration must be greater than 0.';
        }

        // Validate price
        if (isset($data['total_price']) && $data['total_price'] < 0) {
            $errors[] = 'Total price cannot be negative.';
        }

        // Validate deposit amount
        if (isset($data['deposit_amount']) && $data['deposit_amount'] < 0) {
            $errors[] = 'Deposit amount cannot be negative.';
        }

        return $errors;
    }
}