<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Models\City;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index()
    {
        $cities = $this->cityService->listCities();
        return view('dashboard.cities.index', compact('cities'));
    }

    public function create()
    {
        return view('dashboard.cities.create');
    }

    public function store(StoreCityRequest $request)
    {
        $this->cityService->createCity($request->validated());
        return redirect()->route('dashboard.cities.index')->with('message', [
            'type' => 'success',
            'content' => __('dashboard.city_created_successfully')]);
    }

    public function show($id)
    {
        $city = $this->cityService->getCity($id);
        return view('dashboard.cities.show', compact('city'));
    }

    public function edit($id)
    {
        $city = $this->cityService->getCity($id);
        return view('dashboard.cities.edit', compact('city'));
    }

    public function update(UpdateCityRequest $request,City $city)
    {
      
        $this->cityService->updateCity($city, $request->validated());
        return redirect()->route('dashboard.cities.index')->with('message', [
            'type' => 'success',
            'content' => __('dashboard.city_updated_successfully')]);
    }

    public function destroy($id)
    {
        $city = $this->cityService->getCity($id);
        $this->cityService->deleteCity($city);
        return redirect()->route('dashboard.cities.index')->with('message', [
            'type' => 'error',
            'content' => __('dashboard.city_deleted_successfully')]);
    }
}
