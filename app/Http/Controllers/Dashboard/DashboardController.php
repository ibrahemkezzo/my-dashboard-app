<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Booking;
use App\Models\Salon;
use App\Models\SubService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-dashboard')->only(['index']);
    }

    public function index()
    {
        $salons = Salon::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(10) // تحديد عدد الصالونات (مثلاً أعلى 10)
            ->get()->load('owner');

        $users = User::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(10) // تحديد عدد المستخدمين (مثلاً أعلى 10)
            ->get()->load('city');

        $countSalons = Salon::count();
        $countUsers = User::count();
        $countServices = SubService::count();
        $countBookings = Booking::whereBetween('preferred_datetime', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();        // dd($countSalons,$countUsers);
        return view('dashboard.index', compact('salons', 'users', 'countSalons', 'countUsers', 'countServices', 'countBookings'));
    }
}
