<?php

namespace App\View\Components\Dashboard;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class DashboardHeader extends Component
{
    public $user;
    public $logo;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = Auth::user();

        $this->logo = Setting::where('key','site_logo')->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.dashboard-header');
    }
}
