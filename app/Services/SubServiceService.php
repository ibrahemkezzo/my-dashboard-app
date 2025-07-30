<?php

namespace App\Services;

use App\Facades\Media;
use App\Models\SubService;
use App\Repositories\SubServiceRepository;
use Illuminate\Http\UploadedFile;

class SubServiceService
{
    protected $repository;

    public function __construct(SubServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list($perPage = 15, $filters = [])
    {
        return $this->repository->paginate($perPage, $filters);
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data, ?UploadedFile $image = null)
    {
        $sub_service = $this->repository->create($data);
        if ($image) {
            Media::storeSingle($image,$sub_service,'sub_service_image','sub_services','single_column',['column'=>'icon_or_image']);
        }
        return $sub_service;
    }

    public function update(SubService $subService, array $data, ?UploadedFile $image = null)
    {

        unset($data['icon_or_image']);
        $sub_service = $this->repository->update($subService, $data);
        if ($image) {
            Media::delete($subService,'sub_service_image','single_column',['column'=>'icon_or_image']);

            Media::storeSingle($image,$sub_service,'sub_service_image','sub_services','single_column',['column'=>'icon_or_image']);
        }
        return $sub_service;
    }

    public function delete(SubService $subService)
    {
        return $this->repository->delete($subService);
    }
}