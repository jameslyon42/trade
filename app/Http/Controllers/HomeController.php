<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entities\Security;

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
        $securities = Security::limit(5)->get();


        //dd($securities);
        return view('home', compact('securities'));
    }
}
