<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Setting;
use App\Models\SubService;
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
        $subServices = SubService::orderBy('name')->get();
        $cities = City::orderBy('name')->get(['id', 'name']);
        // dd($services);
        return view('frontend.index',compact(['services','subServices', 'cities']));
    }

    public function aboutUs(){
        return view('frontend.pages.about_us');
    }

    public function faq(){
        $questions = Setting::where('key','faq_questions')->first();
        $info = Setting::where('key','faq_description')->first();
        return view('frontend.pages.faq',compact('info','questions'));
    }

    public function privacy(){
        $sections = Setting::where('key','privacy_sections')->first();
        $info = Setting::where('key','privacy_description')->first();

        return view('frontend.pages.privacy',compact('info','sections'));
    }

    public function terms(){
        $terms = Setting::where('key','terms_content')->first();
        $info = Setting::where('key','terms_description')->first();

        return view('frontend.pages.terms',compact('info','terms'));
    }
}
