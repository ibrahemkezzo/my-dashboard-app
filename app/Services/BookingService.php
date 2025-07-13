<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\User;
use App\Models\Salon;
use App\Repositories\BookingRepository;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingService
{
    protected $bookingRepository;
    protected $appointmentRepository;

    public function __construct(BookingRepository $bookingRepository, AppointmentRepository $appointmentRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->appointmentRepository = $appointmentRepository;
    }

    /**
     * Get all bookings with pagination and filters.
     */
    public function list($perPage = 15, $filters = [])
    {
        return $this->bookingRepository->paginate($perPage, $filters);
    }

    /**
     * Get all bookings.
     */
    public function all()
    {
        return $this->bookingRepository->all();
    }

    /**
     * Find a booking by ID.
     */
    public function find($id)
    {
        return $this->bookingRepository->find($id);
    }

    /**
     * Find a booking by booking number.
     */
    public function findByBookingNumber($bookingNumber)
    {
        return $this->bookingRepository->findByBookingNumber($bookingNumber);
    }

    /**
     * Create a new booking.
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Validate that the salon sub-service exists and is active
            // dd($data);
            $salonSubService = DB::table('salon_sub_service')
                ->where('id', $data['salon_sub_service_id'])
                ->where('status', true)
                ->first();

            if (!$salonSubService) {
                throw new \Exception('Selected service is not available.');
            }

            // Validate that the preferred datetime is in the future
            $preferredDatetime = Carbon::parse($data['preferred_datetime']);
            if ($preferredDatetime->isPast()) {
                throw new \Exception('Preferred appointment time must be in the future.');
            }
            // dd($data);
            // Create the booking
            $booking = $this->bookingRepository->create($data);

            Log::info('New booking created', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'user_id' => $booking->user_id,
                'salon_id' => $booking->salon_id,
            ]);

            return $booking;
        });
    }

    /**
     * Update a booking.
     */
    public function update(Booking $booking, array $data)
    {
        return DB::transaction(function () use ($booking, $data) {
            $booking = $this->bookingRepository->update($booking, $data);

            Log::info('Booking updated', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'updated_fields' => array_keys($data),
            ]);

            return $booking;
        });
    }

    /**
     * Delete a booking.
     */
    public function delete(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            // Check if booking has an appointment
            if ($booking->appointment) {
                throw new \Exception('Cannot delete booking with existing appointment.');
            }

            $result = $this->bookingRepository->delete($booking);

            Log::info('Booking deleted', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
            ]);

            return $result;
        });
    }

    /**
     * Confirm a booking and create an appointment.
     */
    public function confirmBooking(Booking $booking, array $appointmentData)
    {
        return DB::transaction(function () use ($booking, $appointmentData) {
            // Check if booking can be confirmed
            if (!$booking->canBeConfirmed()) {
                throw new \Exception('Booking cannot be confirmed in its current status.');
            }

            // Check for scheduling conflicts
            $scheduledDatetime = Carbon::parse($appointmentData['scheduled_datetime']);
            $durationMinutes = $appointmentData['duration_minutes'] ?? 60;

            if ($this->appointmentRepository->checkConflicts(
                $booking->salon_id,
                $scheduledDatetime,
                $durationMinutes
            )) {
                throw new \Exception('There is a scheduling conflict for the selected time.');
            }

            // Update booking status
            $this->bookingRepository->update($booking, ['status' => 'confirmed']);

            // Create appointment
            $appointmentData['booking_id'] = $booking->id;
            $appointment = $this->appointmentRepository->create($appointmentData);

            Log::info('Booking confirmed and appointment created', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->appointment_number,
                'scheduled_datetime' => $appointment->scheduled_datetime,
            ]);

            return $appointment;
        });
    }

    /**
     * Reject a booking.
     */
    public function rejectBooking(Booking $booking, $rejectionReason)
    {
        return DB::transaction(function () use ($booking, $rejectionReason) {
            if (!$booking->canBeRejected()) {
                throw new \Exception('Booking cannot be rejected in its current status.');
            }

            $booking = $this->bookingRepository->update($booking, [
                'status' => 'rejected',
                'rejection_reason' => $rejectionReason,
            ]);

            Log::info('Booking rejected', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'rejection_reason' => $rejectionReason,
            ]);

            return $booking;
        });
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Booking $booking, $cancellationReason = null)
    {
        return DB::transaction(function () use ($booking, $cancellationReason) {
            if (!$booking->canBeCancelled()) {
                throw new \Exception('Booking cannot be cancelled in its current status.');
            }

            $booking = $this->bookingRepository->update($booking, [
                'status' => 'cancelled',
                'rejection_reason' => $cancellationReason,
            ]);

            // If there's an appointment, cancel it too
            if ($booking->appointment) {
                $this->appointmentRepository->update($booking->appointment, [
                    'status' => 'cancelled',
                    'cancellation_reason' => $cancellationReason,
                    'cancelled_at' => now(),
                ]);
            }

            Log::info('Booking cancelled', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'cancellation_reason' => $cancellationReason,
            ]);

            return $booking;
        });
    }

    /**
     * Get bookings for a specific user.
     */
    public function getByUser(User $user, $perPage = 15, $filters = [])
    {
        return $this->bookingRepository->getByUser($user, $perPage, $filters);
    }

    /**
     * Get bookings for a specific salon.
     */
    public function getBySalon(Salon $salon, $perPage = 15, $filters = [])
    {
        return $this->bookingRepository->getBySalon($salon, $perPage, $filters);
    }

    /**
     * Get booking statistics.
     */
    public function getStatistics($filters = [])
    {
        return $this->bookingRepository->getStatistics($filters);
    }

    /**
     * Get recent bookings.
     */
    public function getRecent($limit = 10, $filters = [])
    {
        return $this->bookingRepository->getRecent($limit, $filters);
    }

    /**
     * Validate booking data.
     */
    public function validateBookingData(array $data): array
    {
        $errors = [];

        // Check if user exists and is active
        $user = User::find($data['user_id'] ?? null);
        if (!$user || !$user->is_active) {
            $errors[] = 'Invalid or inactive user.';
        }

        // Check if salon exists and is active
        $salon = Salon::find($data['salon_id'] ?? null);
        if (!$salon || !$salon->status) {
            $errors[] = 'Invalid or inactive salon.';
        }

        // Check if salon sub-service exists and is active
        if (isset($data['salon_sub_service_id'])) {
            $salonSubService = DB::table('salon_sub_service')
                ->where('id', $data['salon_sub_service_id'])
                ->where('salon_id', $data['salon_id'] ?? 0)
                ->where('status', true)
                ->first();

            if (!$salonSubService) {
                $errors[] = 'Selected service is not available for this salon.';
            }
        }

        // Validate preferred datetime
        if (isset($data['preferred_datetime'])) {
            $preferredDatetime = Carbon::parse($data['preferred_datetime']);
            if ($preferredDatetime->isPast()) {
                $errors[] = 'Preferred appointment time must be in the future.';
            }
        }

        // Validate service description
        if (empty($data['service_description'] ?? '')) {
            $errors[] = 'Service description is required.';
        }

        return $errors;
    }
}