<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class dashboardSidebar extends Component
{


    public $sidebarItems;


    /**
     * Create a new component instance.
     */
    public function __construct()
    {
         $this->sidebarItems = config('sidebar.items');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.dashboard-sidebar',[
            'sidebarItems' => $this->sidebarItems,
            'user' => Auth::user(),
        ]);
    }
}
