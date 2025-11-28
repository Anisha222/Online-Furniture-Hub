<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // This controller's ONLY job is to show the public home page.
        // It should NOT redirect anyone.
        return view('home');
    }
}