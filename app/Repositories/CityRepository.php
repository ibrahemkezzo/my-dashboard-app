<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{
    public function all()
    {
        return City::all();
    }

    public function find($id)
    {
        return City::findOrFail($id);
    }

    public function create(array $data)
    {
        return City::create($data);
    }

    public function update(City $city, array $data)
    {
        $updateCity = City::findOrFail($city->id);
        $updateCity->update($data);
        return $updateCity;
    }

    public function delete(City $city)
    {
        return $city->delete();
    }
}
