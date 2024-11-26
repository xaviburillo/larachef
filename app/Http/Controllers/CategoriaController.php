<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class CategoriaController extends Controller
{
    /**
     * Muestra el listado.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {       
        
        $categorias = Categoria::all();
        
        return view('categorias.index', ['categorias' => $categorias]);
    }

    /**
     * Guarda un recurso creado en el almacenamiento.
     *
     * @param  \App\Http\Requests\StoreCategoriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriaRequest $request) {

        $datos = $request->only([
            'titulo'
        ]);

        $categoria = Categoria::create($datos);

        return redirect()->route('categorias.index', $categoria->id)
            ->with('success', "Categoria $categoria->titulo añadida correctamente.");
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UpdateCategoriaRequest  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria) {
        
        $datos = $request->only([
            'titulo'
        ]);

        if (!$categoria->update($datos)) {
            throw new Exception('Algo ha fallado al intentar editar la categoria. Inténtalo de nuevo.');
        }        

        return redirect()->back()
            ->with('success', "Categoria editada correctamente.");
    }

    /**
     * Muestra el formulario para confirmar la eliminación definitiva del recurso especificado.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Categoria $categoria) {

        if ($request->user()->cant('delete', $categoria)) {
            throw new AuthorizationException('No tienes permiso para eliminar definitivamente esta categoria.');
        }

        Session::put('returnTo', URL::previous());
        
        return view('categorias.delete', ['categoria' => $categoria]);
    }

    /**
     * Elimina definitivamente el recurso especificado.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function purge(Request $request) {

        $categoria = Categoria::findOrFail($request->categoria_id);
        $titulo = $categoria->titulo;

        if ($request->user()->cant('delete', $categoria)) {
            throw new AuthorizationException('No tienes permiso para eliminar definitivamente esta categoria.');
        }

        if (!$categoria->forceDelete()) {
            throw new Exception('Algo ha fallado al intentar eliminar definitivamente esta categoria. Inténtalo de nuevo.');
        }      

        $redirect = Session::has('returnTo') ?
                    redirect(Session::get('returnTo')) :
                    redirect()->route('home');

        return $redirect->with(
                'success', 
                "Categoria $titulo eliminada definitivamente."
            );
    }
}
