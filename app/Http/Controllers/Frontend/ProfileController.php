<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\AppointmentRepository;
use App\Repositories\BookingRepository;
use App\Repositories\UserRepository;
use App\Services\BookingService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function account(){
        $user = Auth::user();
        // dd($user);
        return view('frontend.profile.account',compact('user'));
    }
    public function updateAccount(UpdateUserRequest $request,User $user){
        $validated = $request->validated();
        // dd($validated);
        if(!($user->id == Auth::user()->id)){
            return redirect()->back()->with('error','the user is not same user ');
        }
        $userReository = new UserRepository();
        $userService = new UserService($userReository);
        $userService->updateUser(
            $user->id,
            $request->only('name', 'email','phone_number','city_id', 'password')
        );
        return redirect()->route('front.profile.account')->with('message',[
            'type' => 'success',
            'content' => __('user update successfully!')
        ]);
    }
  
    public function favourites(){
        return view('frontend.profile.favourites');
    }

}
