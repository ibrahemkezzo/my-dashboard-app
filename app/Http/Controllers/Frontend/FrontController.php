<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        // dd( asset('frontend/assets/css/styles.css'));
        return view('frontend.index');
    }
}
