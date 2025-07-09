<?php

namespace App\Services;

use App\Repositories\CityRepository;
use App\Models\City;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function listCities()
    {
        return $this->cityRepository->all();
    }

    public function getCity($id)
    {
        return $this->cityRepository->find($id);
    }

    public function createCity(array $data)
    {
        // Placeholder: In future, integrate Google Maps API here
        return $this->cityRepository->create($data);
    }

    public function updateCity(City $city, array $data)
    {
        // Placeholder: In future, update Google Maps data here
        return $this->cityRepository->update($city, $data);
    }

    public function deleteCity(City $city)
    {
        return $this->cityRepository->delete($city);
    }
}
