<?php

namespace App\View\Components\Frontend;

use App\Models\Salon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SalonsList extends Component
{
    public $salons;
    /**
     * Create a new component instance.
     */
    /**
     * @param int|null $limit
     * @param string|null $status 'active', 'inactive', or 'all' (default: all)
     */
    public function __construct($limit = null, $status = null ,$promoted = null)
    {
        $query = Salon::with(['subServices', 'city', 'owner']);
        if ($status === 'active') {
            $query->where('status', true);
        } elseif ($status === 'inactive') {
            $query->where('status', false);
        }
        if ($promoted === 'active') {
            $query->where('is_promoted', true);
        } elseif ($promoted === 'inactive') {
            $query->where('is_promoted', false);
        }
        if ($limit) {
            $query->limit($limit);
        }
        $this->salons = $query->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.salons-list');
    }
}
