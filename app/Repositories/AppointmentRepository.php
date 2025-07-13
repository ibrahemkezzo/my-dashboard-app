<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Booking;
use App\Models\User;
use App\Models\Salon;
use Illuminate\Support\Collection;

class AppointmentRepository
{
    /**
     * Get all appointments with relationships.
     */
    public function all()
    {
        return Appointment::with(['booking.user', 'booking.salon', 'booking.salonSubService.subService.service'])
            ->orderBy('scheduled_datetime', 'desc')
            ->get();
    }

    /**
     * Get paginated appointments with filters.
     */
    public function paginate($perPage = 15, $filters = [])
    {
        $query = Appointment::with(['booking.user', 'booking.salon', 'booking.salonSubService.subService.service']);

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('appointment_number', 'like', '%' . $filters['search'] . '%')
                  ->orWhereHas('booking.user', function($userQuery) use ($filters) {
                      $userQuery->where('name', 'like', '%' . $filters['search'] . '%');
                  })
                  ->orWhereHas('booking.salon', function($salonQuery) use ($filters) {
                      $salonQuery->where('name', 'like', '%' . $filters['search'] . '%');
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (!empty($filters['salon_id'])) {
            $query->whereHas('booking', function($q) use ($filters) {
                $q->where('salon_id', $filters['salon_id']);
            });
        }

        if (!empty($filters['user_id'])) {
            $query->whereHas('booking', function($q) use ($filters) {
                $q->where('user_id', $filters['user_id']);
            });
        }

        if (!empty($filters['date_from'])) {
            $query->where('scheduled_datetime', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('scheduled_datetime', '<=', $filters['date_to']);
        }

        return $query->orderBy('scheduled_datetime', 'desc')->paginate($perPage);
    }

    /**
     * Find an appointment by ID.
     */
    public function find($id)
    {
        return Appointment::with(['booking.user', 'booking.salon', 'booking.salonSubService.subService.service'])
            ->findOrFail($id);
    }

    /**
     * Find an appointment by appointment number.
     */
    public function findByAppointmentNumber($appointmentNumber)
    {
        return Appointment::with(['booking.user', 'booking.salon', 'booking.salonSubService.subService.service'])
            ->where('appointment_number', $appointmentNumber)
            ->first();
    }

    /**
     * Create a new appointment.
     */
    public function create(array $data)
    {
        return Appointment::create($data);
    }

    /**
     * Update an appointment.
     */
    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);
        return $appointment;
    }

    /**
     * Delete an appointment.
     */
    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }

    /**
     * Get appointments for a specific user.
     */
    public function getByUser(User $user, $perPage = 15, $filters = [])
    {
        $query = $user->appointments()->with(['booking.salon', 'booking.salonSubService.subService.service']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('scheduled_datetime', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('scheduled_datetime', '<=', $filters['date_to']);
        }

        return $query->orderBy('scheduled_datetime', 'desc')->paginate($perPage);
    }

    /**
     * Get appointments for a specific salon.
     */
    public function getBySalon(Salon $salon, $perPage = 15, $filters = [])
    {
        $query = $salon->appointments()->with(['booking.user', 'booking.salonSubService.subService.service']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (!empty($filters['user_id'])) {
            $query->whereHas('booking', function($q) use ($filters) {
                $q->where('user_id', $filters['user_id']);
            });
        }

        if (!empty($filters['date_from'])) {
            $query->where('scheduled_datetime', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('scheduled_datetime', '<=', $filters['date_to']);
        }

        return $query->orderBy('scheduled_datetime', 'desc')->paginate($perPage);
    }

    /**
     * Get appointments for a specific booking.
     */
    public function getByBooking(Booking $booking)
    {
        return $booking->appointment;
    }

    /**
     * Get today's appointments.
     */
    public function getTodayAppointments($filters = [])
    {
        $query = Appointment::with(['booking.user', 'booking.salon', 'booking.salonSubService.subService.service'])
            ->whereDate('scheduled_datetime', today());

        if (!empty($filters['salon_id'])) {
            $query->whereHas('booking', function($q) use ($filters) {
                $q->where('salon_id', $filters['salon_id']);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('scheduled_datetime')->get();
    }

    /**
     * Get upcoming appointments.
     */
    public function getUpcomingAppointments($days = 7, $filters = [])
    {
        $query = Appointment::with(['booking.user', 'booking.salon', 'booking.salonSubService.subService.service'])
            ->where('scheduled_datetime', '>=', now())
            ->where('scheduled_datetime', '<=', now()->addDays($days));

        if (!empty($filters['salon_id'])) {
            $query->whereHas('booking', function($q) use ($filters) {
                $q->where('salon_id', $filters['salon_id']);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('scheduled_datetime')->get();
    }

    /**
     * Get appointment statistics.
     */
    public function getStatistics($filters = [])
    {
        $query = Appointment::query();

        if (!empty($filters['salon_id'])) {
            $query->whereHas('booking', function($q) use ($filters) {
                $q->where('salon_id', $filters['salon_id']);
            });
        }

        if (!empty($filters['user_id'])) {
            $query->whereHas('booking', function($q) use ($filters) {
                $q->where('user_id', $filters['user_id']);
            });
        }

        if (!empty($filters['date_from'])) {
            $query->where('scheduled_datetime', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('scheduled_datetime', '<=', $filters['date_to']);
        }

        return [
            'total' => $query->count(),
            'scheduled' => (clone $query)->where('status', 'scheduled')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
            'no_show' => (clone $query)->where('status', 'no_show')->count(),
            'payment_pending' => (clone $query)->where('payment_status', 'pending')->count(),
            'payment_completed' => (clone $query)->where('payment_status', 'paid')->count(),
        ];
    }

    /**
     * Check for scheduling conflicts.
     */
    public function checkConflicts($salonId, $scheduledDatetime, $durationMinutes, $excludeAppointmentId = null)
    {
        $startTime = $scheduledDatetime;
        $endTime = $scheduledDatetime->copy()->addMinutes($durationMinutes);

        $query = Appointment::whereHas('booking', function($q) use ($salonId) {
            $q->where('salon_id', $salonId);
        })
        ->where('status', '!=', 'cancelled')
        ->where('status', '!=', 'no_show')
        ->where(function($q) use ($startTime, $endTime) {
            $q->whereBetween('scheduled_datetime', [$startTime, $endTime])
              ->orWhereBetween('scheduled_datetime', [
                  $startTime->copy()->subMinutes($durationMinutes),
                  $startTime
              ]);
        });

        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }

        return $query->exists();
    }
} 