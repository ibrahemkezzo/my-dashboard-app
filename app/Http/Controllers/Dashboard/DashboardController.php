<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller ;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-dashboard')->only(['index']);

    }

    public function index(){
        return view('dashboard.index');
    }
}
