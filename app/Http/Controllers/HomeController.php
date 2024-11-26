<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {

        $recetas = $request->user()->recetas()->withAvgRating()->get();
        $recetasFavoritas = $request->user()->favoritas()->withAvgRating()->get();
        $valoraciones = $request->user()->valoraciones()->get();
        $deletedRecetas = $request->user()->recetas()->onlyTrashed()->get();

        return view('home', [
            'recetas' => $recetas,
            'recetasFavoritas' => $recetasFavoritas,
            'valoraciones' => $valoraciones,
            'deletedRecetas' => $deletedRecetas
        ]);
    }
}
