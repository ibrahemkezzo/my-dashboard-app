<?php

namespace App\View\Components\Frontend;

use App\Repositories\DatabaseSettingsRepository;
use App\Services\SettingsService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontFooter extends Component
{
    public $settings;
    protected DatabaseSettingsRepository $settingsRepository;
    /**
     * Create a new component instance.
     */
    public function __construct(DatabaseSettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
        $this->settings = $this->settingsRepository->all('general');
        // dd($this->settings);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.front-footer');
    }
}
