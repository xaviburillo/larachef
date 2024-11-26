<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Auth::routes(['verify' => true]);

Route::get('/contacto', [ContactoController::class, 'index'])
    ->name('contacto');

Route::post('/contacto', [ContactoController::class, 'send'])
    ->name('contacto.email');

Route::get('/recetas', [RecetaController::class, 'index'])
    ->name('recetas.list');

Route::get('/recetas/no-publicadas', [RecetaController::class, 'noPublicadas'])
    ->name('recetas.noPublicadas');

Route::get('/recetas/rechazadas', [RecetaController::class, 'rechazadas'])
    ->name('recetas.rechazadas');

Route::get('/recetas/create', [RecetaController::class, 'create'])
    ->name('recetas.create');

Route::get('/recetas/search/{palabra?}', [RecetaController::class, 'search'])
    ->name('recetas.search');

Route::get('/recetas/no-publicadas/search/{palabra?}', [RecetaController::class, 'searchNoPublicadas'])
    ->name('recetas.noPublicadas.search');

Route::get('/recetas/rechazadas/search/{palabra?}', [RecetaController::class, 'searchRechazadas'])
    ->name('recetas.rechazadas.search');

Route::get('/recetas/{receta}', [RecetaController::class, 'show'])
    ->name('recetas.show');

Route::post('/recetas', [RecetaController::class, 'store'])
    ->name('recetas.store');

Route::get('/recetas/{receta}/edit', [RecetaController::class, 'edit'])
    ->name('recetas.edit');
    
Route::put('/recetas/{receta}', [RecetaController::class, 'update'])
    ->name('recetas.update');
    
Route::get('/recetas/{receta}/delete', [RecetaController::class, 'delete'])
    ->name('recetas.delete');
    
Route::get('/recetas/{receta}/restore', [RecetaController::class, 'restore'])
    ->name('recetas.restore');

Route::delete('/recetas/purge', [RecetaController::class, 'purge'])
    ->name('recetas.purge');

Route::delete('/recetas/{receta}', [RecetaController::class, 'destroy'])
    ->name('recetas.destroy');

Route::post('/recetas/favorite', [RecetaController::class, 'favorite'])
    ->name('recetas.favorite');
    
Route::post('/recetas/unfavorite', [RecetaController::class, 'unfavorite'])
->name('recetas.unfavorite');

Route::patch('/recetas/publicar', [RecetaController::class, 'publicar'])
    ->name('recetas.publicar');

Route::patch('/recetas/rechazar', [RecetaController::class, 'rechazar'])
    ->name('recetas.rechazar');

Route::post('/valoraciones', [ValoracionController::class, 'store'])
    ->name('valoraciones.store');

Route::put('/valoraciones/{valoracion}', [ValoracionController::class, 'update'])
    ->name('valoraciones.update');

Route::delete('/valoraciones/purge', [ValoracionController::class, 'purge'])
    ->name('valoraciones.purge');

Route::delete('/valoraciones/{valoracion}', [ValoracionController::class, 'destroy'])
    ->name('valoraciones.destroy');

Route::get('/categorias', [CategoriaController::class, 'index'])
    ->name('categorias.index');
    
Route::post('/categorias', [CategoriaController::class, 'store'])
    ->name('categorias.store');

Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])
    ->name('categorias.update');

Route::delete('/categorias/purge', [CategoriaController::class, 'purge'])
    ->name('categorias.purge');

Route::get('/categorias/{categoria}/delete', [CategoriaController::class, 'delete'])
    ->name('categorias.delete');

Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

Route::delete('/profile/delete', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');
    
Route::get('/usuario/{user}', [UserController::class, 'show'])
    ->name('users.show');

Route::get('/bloqueado', [UserController::class, 'blocked'])
    ->name('users.blocked');

Route::prefix('admin')->middleware('auth', 'admin')->group(function () {

    Route::get('/usuario/{user}/detalles', [AdminController::class, 'userShow'])
        ->name('admin.user.show');

    Route::get('/usuarios', [AdminController::class, 'userList'])
        ->name('admin.users');

    Route::get('/usuario/buscar', [AdminController::class, 'userSearch'])
        ->name('admin.users.search');

    Route::post('/usuario/role', [AdminController::class, 'setRole'])
        ->name('admin.user.setRole');

    Route::delete('/usuario/role', [AdminController::class, 'removeRole'])
        ->name('admin.user.removeRole');
    
    Route::get('/usuario/{user}/bloquear', [AdminController::class, 'bloquear'])
        ->name('admin.user.bloquear');

    Route::get('/usuario/{user}/desbloquear', [AdminController::class, 'desbloquear'])
        ->name('admin.user.desbloquear');
});

Route::fallback([WelcomeController::class, 'index']);