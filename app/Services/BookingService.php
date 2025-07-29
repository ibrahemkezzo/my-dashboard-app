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
     * Salon confirms or modifies a booking.
     */
    public function salonConfirmBooking(Booking $booking, array $data)
    {
        return DB::transaction(function () use ($booking, $data) {
            // Check if booking can be confirmed by salon
            if (!$booking->canBeConfirmedBySalon()) {
                throw new \Exception('Booking cannot be confirmed by salon in its current status.');
            }

            $action = $data['action'];
            $updateData = [
                'status' => 'salon_confirmed',
                'salon_confirmed_datetime' => now(),
                'salon_notes' => $data['salon_notes'] ?? null,
            ];

            if ($action === 'modify') {
                // Salon is modifying the booking
                $updateData['salon_proposed_datetime'] = $data['salon_proposed_datetime'] ?? null;
                $updateData['salon_proposed_price'] = $data['salon_proposed_price'] ?? null;
                $updateData['salon_proposed_duration'] = $data['salon_proposed_duration'] ?? null;
                $updateData['salon_modification_reason'] = $data['salon_modification_reason'] ?? null;

                // Validate proposed datetime if provided
                if (isset($data['salon_proposed_datetime'])) {
                    $proposedDatetime = Carbon::parse($data['salon_proposed_datetime']);
                    if ($proposedDatetime->isPast()) {
                        throw new \Exception('Proposed appointment time must be in the future.');
                    }
                }
            }

            $booking = $this->bookingRepository->update($booking, $updateData);

            Log::info('Booking confirmed/modified by salon', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'action' => $action,
                'modified' => $action === 'modify',
            ]);

            return $booking;
        });
    }

    /**
     * User confirms salon's response and creates appointment.
     */
    public function userConfirmBooking(Booking $booking, array $data)
    {
        return DB::transaction(function () use ($booking, $data) {
            // Check if booking can be confirmed by user
            if (!$booking->canBeConfirmedByUser()) {
                throw new \Exception('Booking cannot be confirmed by user in its current status.');
            }

            $action = $data['action'];

            if ($action === 'confirm') {
                // User confirms the salon's response
                $booking = $this->bookingRepository->update($booking, [
                    'status' => 'user_confirmed',
                    'user_confirmed_datetime' => now(),
                ]);

                // APPOINTMENT SYSTEM SUSPENDED: Do not create appointment
                // (No appointment creation here)

                Log::info('Booking confirmed by user', [
                    'booking_id' => $booking->id,
                    'booking_number' => $booking->booking_number,
                ]);

                return $booking;
            } else {
                // User rejects the salon's response
                $booking = $this->bookingRepository->update($booking, [
                    'status' => 'rejected',
                    'rejection_reason' => $data['user_notes'] ?? 'Rejected by user',
                ]);

                Log::info('Booking rejected by user', [
                    'booking_id' => $booking->id,
                    'booking_number' => $booking->booking_number,
                    'user_notes' => $data['user_notes'] ?? null,
                ]);

                return $booking;
            }
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

            // APPOINTMENT SYSTEM SUSPENDED: Do not cancel appointment
            // (No appointment update here)

            Log::info('Booking cancelled', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'cancellation_reason' => $cancellationReason,
            ]);

            return $booking;
        });
    }

    /**
     * Mark a booking as completed.
     */
    public function markBookingCompleted(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            if ($booking->status !== 'user_confirmed') {
                throw new \Exception('Only user confirmed bookings can be marked as completed.');
            }
            $booking = $this->bookingRepository->update($booking, [
                'status' => 'completed',
            ]);
            Log::info('Booking marked as completed', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
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