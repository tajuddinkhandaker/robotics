<?php

namespace Robotics\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $appName;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->appName = strtolower(config('app.name'));
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
        return view($this->appName.'.homes.clients');
    }
}
