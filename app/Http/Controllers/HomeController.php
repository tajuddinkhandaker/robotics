<?php

namespace Robotics\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the clients of the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function clients()
    {
        return view(strtolower(config('app.name')) . '.homes.clients');
    }
}
