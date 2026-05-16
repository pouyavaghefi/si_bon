<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
class LandingController extends FrontendController
{
    public function index()
    {
        return view('frontend.index');
    }
}
