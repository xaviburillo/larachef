<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreValoracionRequest;
use App\Http\Requests\UpdateValoracionRequest;
use App\Models\Valoracion;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    /**
     * Define the controller's middlewares.
     */
    public function __construct() {
        $this->middleware('signed')->only(['update', 'destroy']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreValoracionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreValoracionRequest $request) {
        
        $datos = $request->only([
            'rating', 
            'texto', 
        ]);

        $datos['user_id'] = $request->user()->id;
        $datos['receta_id'] = $request->receta_id;

        Valoracion::create($datos);

        return redirect()->back()
            ->with('success', "Valoración añadida correctamente.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateValoracionRequest  $request
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateValoracionRequest $request, Valoracion $valoracion) {
        
        $datos = $request->only([
            'texto', 
        ]);

        if ($request->user()->cant('update', $valoracion)) {
            throw new Exception('No tienes permisos para editar esta valoración.');
        }

        if (!$valoracion->update($datos)) {
            throw new Exception('Algo ha fallado al intentar editar la valoración. Inténtalo de nuevo.');
        }        

        return redirect()->back()
            ->with('success', "Valoración editada correctamente.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valoracion $valoracion) {
        
        if (!$valoracion->delete()) {
            throw new Exception('Algo ha fallado al intentar borrar la valoración. Inténtalo de nuevo.');
        }
        return redirect()->back()
            ->with('success', "Valoración eliminada correctamente.");
    }

    /**
     * Elimina definitivamente el recurso especificado.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function purge(Request $request) {

        $valoracion = Valoracion::withTrashed()->findOrFail($request->comentario_id);

        if ($request->user()->cant('forceDelete', $valoracion)) {
            throw new AuthorizationException('No tienes permiso para eliminar definitivamente esta valoración.');
        }
        
        if (!$valoracion->forceDelete()) {
            throw new Exception('Algo ha fallado al intentar borrar la valoración. Inténtalo de nuevo.');
        }

        return redirect()->back()
            ->with('success', "Valoración eliminada correctamente.");
    }
}
