<?php

namespace App\Http\Controllers;

use App\Postagem;

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
     */
    public function index()
    {
        $array['postagens'] = Postagem::orderBy('updated_at', 'desc')->get();

        return view('home', $array);
    }
}
