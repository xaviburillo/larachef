<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRecetaRequest;
use App\Http\Requests\Api\UpdateRecetaRequest;
use App\Models\Receta;
use Illuminate\Http\Request;

class RecetaController extends Controller {
    
    /**
     * Devuelve el listado de las recetas publicadas.
     *
     * @return Array
     */
    public function index() {

        $recetas = Receta::orderBy('id', 'DESC')->get();

        return [
            'status' => 'OK',
            'total' => count($recetas),
            'results' => $recetas
        ];
    }

    /**
     * Devuelve el listado de las recetas no publicadas.
     *
     * @return Array
     */
    public function noPublicadas() {
        
        $recetas = Receta::noPublicadasNoRechazadas()
            ->orderBy('created_at', 'DESC')
            ->get();
        
        return [
            'status' => 'OK',
            'total' => count($recetas),
            'results' => $recetas
        ];
    }

    /**
     * Devuelve el listado de las recetas rechazadas.
     *
     * @return Array
     */
    public function rechazadas() {
        
        $recetas = Receta::rechazadas()
            ->orderBy('created_at', 'DESC')
            ->get();
        
        return [
            'status' => 'OK',
            'total' => count($recetas),
            'results' => $recetas
        ];
    }

    /**
     * Devuelve la receta especificada.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $receta = Receta::find($id);

        return $receta ?
            [
                'status' => 'OK',
                'results' => [$receta]
            ] :
            response(['status' => 'NOT FOUND']);
    }

    /**
     * Devuelve los resultados de la búsqueda de recetas publicadas.
     * 
     * @param string $palabra
     * @return Array
     */
    public function search($palabra = '') {

        $recetas = Receta::publicadas()
            ->where('titulo', 'like', "%$palabra%")
            ->orWhereHas('categorias', function ($query) use ($palabra) {
                $query->where('titulo', 'like', "%$palabra%");
            })        
            ->get();

        return [
            'status' => 'OK',
            'total' => count($recetas),
            'results' => $recetas
        ];
    }

    /**
     * Devuelve los resultados de la búsqueda de recetas no publicadas.
     * 
     * @param string $palabra
     * @return Array
     */
    public function searchNoPublicadas($palabra = '') {

        $recetas = Receta::noPublicadasNoRechazadas()
            ->where('titulo', 'like', "%$palabra%")
            ->orWhereHas('categorias', function ($query) use ($palabra) {
                $query->where('titulo', 'like', "%$palabra%");
            })        
            ->get();

        return [
            'status' => 'OK',
            'total' => count($recetas),
            'results' => $recetas
        ];
    }

    /**
     * Devuelve los resultados de la búsqueda de recetas rechazadas.
     * 
     * @param string $palabra
     * @return Array
     */
    public function searchRechazadas($palabra = '') {

        $recetas = Receta::rechazadas()
            ->where('titulo', 'like', "%$palabra%")
            ->orWhereHas('categorias', function ($query) use ($palabra) {
                $query->where('titulo', 'like', "%$palabra%");
            })        
            ->get();

        return [
            'status' => 'OK',
            'total' => count($recetas),
            'results' => $recetas
        ];
    }

    public function store(StoreRecetaRequest $request) {

        $datos = $request->json()->all();
        $datos['imagen'] = NULL;

        $receta = Receta::create($datos);

        return $receta ?
            response([
                'status' => 'OK',
                'results' => [$receta]
            ], 201) :
            response([
                'status' => 'ERROR',
                'message' => 'Error al guardar la receta.'
            ], 400);
    }

    public function update(UpdateRecetaRequest $request, $id) {
        
        $receta = Receta::find($id);

        if (!$receta) {
            return response(['status' => 'NOT FOUND'], 404);
        }

        $datos = $request->json()->all();

        return $receta->update($datos) ?
            response([
                'status' => 'OK',
                'results' => [$receta]
            ], 200) :
            response([
                'status' => 'ERROR',
                'message' => 'Error al actualizar la receta.'
            ], 400);
    }

    public function delete($id) {
        
        $receta = Receta::find($id);

        if (!$receta) {
            return response(['status' => 'NOT FOUND'], 404);
        }

        return $receta->delete() ?
            response(['status' => 'OK']) :
            response([
                'status' => 'ERROR',
                'message' => 'Error al eliminar la receta.'
            ], 400);
    }
}
