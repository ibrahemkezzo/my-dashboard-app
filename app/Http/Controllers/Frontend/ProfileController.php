<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToggleFavoriteRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\AppointmentRepository;
use App\Repositories\BookingRepository;
use App\Repositories\UserRepository;
use App\Services\BookingService;
use App\Services\FavoriteService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }


    public function account()
    {
        $user = Auth::user();
        // dd($user);
        return view('frontend.profile.account', compact('user'));
    }
    public function updateAccount(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        // dd($validated);
        if (!($user->id == Auth::user()->id)) {
            return redirect()->back()->with('error', 'the user is not same user ');
        }
        $userReository = new UserRepository();
        $userService = new UserService($userReository);
        $userService->updateUser(
            $user->id,
            $request->only('name', 'email', 'phone_number', 'city_id', 'password')
        );
        return redirect()->route('front.profile.account')->with('message', [
            'type' => 'success',
            'content' => __('user update successfully!')
        ]);
    }

    public function favourites(Request $request)
    {
        $user = Auth::user();
        $favorites = $this->favoriteService->getFavoriteSalons($user);

        return view('frontend.profile.favourites', compact('favorites'));
    }

    public function toggleFavorite(ToggleFavoriteRequest $request): JsonResponse
    {
        $user = Auth::user();
        $salonId = $request->input('salon_id');
        $result = $this->favoriteService->toggleFavorite($user, $salonId);

        return response()->json($result);
    }
}
