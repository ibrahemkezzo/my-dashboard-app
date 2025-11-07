<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;
use Livewire\Component;

class UnifiedAuth extends Component
{
    public $email = '';
    public $password = '';
    public $name = '';
    public $phone_number = '';
    public $city_id = '';
    public $password_confirmation = '';
    public $agree_terms = false;
    public $remember = false;

    public $step = 'email'; // 'email', 'login', 'register'

    protected $listeners = ['backToEmail'];

    public function checkEmail()
    {
        $this->validate(['email' => 'required|email']);

        $user = \App\Models\User::where('email', $this->email)->first();

        if ($user) {
            $this->step = 'login';
        } else {
            $this->step = 'register';
        }

        $this->resetErrorBag();
    }
    public function attemptLogin()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            // تفعيل الـ Login event (مثل Fortify)
            event(new \Illuminate\Auth\Events\Login('web', Auth::user(), $this->remember));

            return redirect()->intended(Fortify::redirects('login'))->with('message',[
                    'type' => 'success',
                    // 'content' => "مرحباً بعودتك! تم تسجيل الدخول عبر $driverName",
                    'img' => asset('frontend/assets/img/welcome-login.png'), // أو صورة صغيرة
                ]);
        }

        throw ValidationException::withMessages([
            'password' => [trans('auth.password')],
        ]);
    }

    public function attemptRegister()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|confirmed|min:8',
            'agree_terms' => 'accepted',
        ]);

        // استخدم Fortify لإنشاء المستخدم (يحفظ الـ Registered event)
        $user = app(CreatesNewUsers::class)->create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'agree_terms' => $this->agree_terms,
        ]);

        Auth::login($user, $this->remember);

        return redirect()->intended(Fortify::redirects('login'));
    }

    public function backToEmail()
    {
        $this->step = 'email';
        $this->reset(['password', 'name', 'phone_number', 'city_id', 'password_confirmation', 'agree_terms']);
    }
    public function render()
    {
        return view('livewire.unified-auth');
    }
}
