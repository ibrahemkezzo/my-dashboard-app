<?php

namespace App\View\Components\Frontend;

use App\Repositories\CityRepository;
use App\Repositories\DatabaseSettingsRepository;
use App\Services\SettingsService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontFooter extends Component
{
    public $settings;
    public $cities;
    protected DatabaseSettingsRepository $settingsRepository;
    protected CityRepository $cityRepository;

    /**
     * Create a new component instance.
     */
    public function __construct(DatabaseSettingsRepository $settingsRepository,CityRepository $cityRepository)
    {
        $this->settingsRepository = $settingsRepository;
        $this->cityRepository = $cityRepository;
        
        $this->settings = $this->settingsRepository->all('general');
        $this->cities = $this->cityRepository->all();
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
