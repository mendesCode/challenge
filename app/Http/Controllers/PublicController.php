<?php

namespace App\Http\Controllers;

use App\Postagem;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Postagem::all()->where('ativa', 'S');

        return view('public', ['posts' => $posts]);
    }

    public function postagem($id)
    {
        $post = Postagem::where('id', $id)->where('ativa', 'S')->firstOrFail();

        return view('public_post', ['post' => $post]);
    }
}
