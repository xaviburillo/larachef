<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function show(int $id) {

        $user = User::findOrFail($id);
        
        $recetas = $user->recetas()->withAvgRating()->get();
        
        $userRating = $recetas->avg('valoraciones_avg_rating');

        return view('users.show', ['user' => $user, 'userRating' => $userRating, 'recetas' => $recetas]);
    }
    
    public function blocked() {
        return view('users.blocked');
    }
}
