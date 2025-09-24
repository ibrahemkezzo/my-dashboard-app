<?php

namespace App\View\Components\Frontend;

use App\Repositories\DatabaseSettingsRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class FrontHeader extends Component
{
    public $settings;
    public $user;
    protected DatabaseSettingsRepository $settingsRepository;

    /**
     * Create a new component instance.
     */
    public function __construct(DatabaseSettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
        $this->settings = $this->settingsRepository->all('general');
        $this->user = Auth::user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.front-header');
    }
}
