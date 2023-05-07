<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('content.landing-page.index');
    }


    public function about()
    {
        return view('content.landing-page.about');
    }
    
    public function howItWork()
    {
        return view('content.landing-page.how_it_work');
    }

    public function termsAndCondition()
    {
        return view('content.landing-page.terms_and_condition');
    }

    public function faq()
    {
        return view('content.landing-page.faq');
    }

}
