<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\SubServiceRepository;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $subServiceRepository;

    public function __construct(SubServiceRepository $subServiceRepository)
    {
        $this->subServiceRepository = $subServiceRepository;
    }
    public function index(){
        // dd( asset('frontend/assets/css/styles.css'));
        $services = $this->subServiceRepository->allService();
        // dd($services);
        return view('frontend.index',compact('services'));
    }
}
