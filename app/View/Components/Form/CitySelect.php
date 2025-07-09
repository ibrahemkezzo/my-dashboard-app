<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\City;

class CitySelect extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;
    public $selected;
    public $cities;
    public $class;

    public function __construct($name = 'city_id', $selected = null, $class = null)
    {
        $this->name = $name;
        $this->selected = $selected;
        $this->class = $class;
        $this->cities = City::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.city-select', [
            'cities' => $this->cities,
            'name' => $this->name,
            'selected' => $this->selected,
            'class' => $this->class,
        ]);
    }
}
