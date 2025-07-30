<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardBreadcrumb extends Component
{

    public $breadcrumbs;

    public $pageName;

    /**
     * Create a new component instance.
     */
    public function __construct(array $breadcrumbs = [], string $pageName = '')
    {
        $this->breadcrumbs = $breadcrumbs;

        $this->pageName = $pageName;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.dashboard-breadcrumb');
    }
}
