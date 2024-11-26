<?php

use App\Http\Controllers\Api\RecetaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/recetas', [RecetaController::class, 'index']);

Route::get('/recetas/no-publicadas', [RecetaController::class, 'noPublicadas']);

Route::get('/recetas/rechazadas', [RecetaController::class, 'rechazadas']);

Route::get('/receta/{receta}', [RecetaController::class, 'show'])
    ->where('receta', '^\d+$');

Route::get('/recetas/search/{palabra?}', [RecetaController::class, 'search']);

Route::get('/recetas/no-publicadas/search/{palabra?}', [RecetaController::class, 'searchNoPublicadas']);

Route::get('/recetas/rechazadas/search/{palabra?}', [RecetaController::class, 'searchRechazadas']);

Route::post('/receta', [RecetaController::class, 'store']);

Route::put('/receta/{receta}', [RecetaController::class, 'update']);

Route::delete('/receta/{receta}', [RecetaController::class, 'delete']);

Route::fallback(function() {
    return response(['status' => 'BAD REQUEST'], 400);
});