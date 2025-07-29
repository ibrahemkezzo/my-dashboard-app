<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Salon;
use Illuminate\Support\Collection;

class BookingRepository
{
    /**
     * Get all bookings with relationships.
     */
    public function all()
    {
        return Booking::with(['user', 'salon', 'salonSubService.subService.service'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get paginated bookings with filters.
     */
    public function paginate($perPage = 15, $filters = [])
    {
        $query = Booking::with(['user', 'salon', 'salonSubService.subService.service']);

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('booking_number', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('service_description', 'like', '%' . $filters['search'] . '%')
                  ->orWhereHas('user', function($userQuery) use ($filters) {
                      $userQuery->where('name', 'like', '%' . $filters['search'] . '%');
                  })
                  ->orWhereHas('salon', function($salonQuery) use ($filters) {
                      $salonQuery->where('name', 'like', '%' . $filters['search'] . '%');
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['salon_id'])) {
            $query->where('salon_id', $filters['salon_id']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('preferred_datetime', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('preferred_datetime', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Find a booking by ID.
     */
    public function find($id)
    {
        return Booking::with(['user', 'salon', 'salonSubService.subService.service'])
            ->findOrFail($id);
    }

    /**
     * Find a booking by booking number.
     */
    public function findByBookingNumber($bookingNumber)
    {
        return Booking::with(['user', 'salon', 'salonSubService.subService.service'])
            ->where('booking_number', $bookingNumber)
            ->first();
    }

    /**
     * Create a new booking.
     */
    public function create(array $data)
    {
        return Booking::create($data);
    }

    /**
     * Update a booking.
     */
    public function update(Booking $booking, array $data)
    {
        $booking->update($data);
        return $booking;
    }

    /**
     * Delete a booking.
     */
    public function delete(Booking $booking)
    {
        return $booking->delete();
    }

    /**
     * Get bookings for a specific user.
     */
    public function getByUser(User $user, $perPage = 15, $filters = [])
    {
        $query = $user->bookings()->with(['salon', 'salonSubService.subService.service']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('preferred_datetime', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('preferred_datetime', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get bookings for a specific salon.
     */
    public function getBySalon(Salon $salon, $perPage = 15, $filters = [])
    {
        $query = $salon->bookings()->with(['user', 'salonSubService.subService.service']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('preferred_datetime', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('preferred_datetime', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get booking statistics.
     */
    public function getStatistics($filters = [])
    {
        $query = Booking::query();

        if (!empty($filters['salon_id'])) {
            $query->where('salon_id', $filters['salon_id']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        return [
            'total' => $query->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'salon_confirmed' => (clone $query)->where('status', 'salon_confirmed')->count(),
            'user_confirmed' => (clone $query)->where('status', 'user_confirmed')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'rejected' => (clone $query)->where('status', 'rejected')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Get recent bookings.
     */
    public function getRecent($limit = 10, $filters = [])
    {
        $query = Booking::with(['user', 'salon', 'salonSubService.subService.service']);

        if (!empty($filters['salon_id'])) {
            $query->where('salon_id', $filters['salon_id']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->orderBy('created_at', 'desc')->limit($limit)->get();
    }
} 