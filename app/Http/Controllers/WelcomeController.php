<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {       
        
        $receta = Receta::where('published_at', '!=', null)
            ->where('rejected', '=', false)
            ->withAvgRating()
            ->inRandomOrder()
            ->first();
        
        return view('welcome', ['receta' => $receta]);
    }
}
