<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecetaRequest;
use App\Http\Requests\UpdateRecetaRequest;
use App\Models\Categoria;
use App\Models\Receta;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class RecetaController extends Controller
{
    /**
     * Define the controller's middlewares.
     */
    public function __construct() {
        $this->middleware('signed')->only('update', 'destroy');
        $this->middleware('verified')->only('create', 'store');
    }

    /**
     * Muestra el listado.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {       
        
        $recetas = Receta::publicadas()
            ->withAvgRating()
            ->orderBy('published_at', 'DESC')
            ->paginate(12);
        
        return view('recetas.index', ['recetas' => $recetas]);
    }

    /**
     * Muestra el listado de las recetas no publicadas.
     *
     * @return \Illuminate\Http\Response
     */
    public function noPublicadas() {
        
        $recetas = Receta::noPublicadasNoRechazadas()
            ->orderBy('created_at', 'DESC')
            ->paginate(12);
        
        return view('recetas.noPublicadas', ['recetas' => $recetas]);
    }

    /**
     * Muestra el listado de las recetas rechazadas.
     *
     * @return \Illuminate\Http\Response
     */
    public function rechazadas() {
        
        $recetas = Receta::rechazadas()
            ->orderBy('created_at', 'DESC')
            ->paginate(12);
        
        return view('recetas.rechazadas', ['recetas' => $recetas]);
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $categorias = Categoria::all();

        return view('recetas.create', ['categorias' => $categorias]);
    }

    /**
     * Guarda un recurso creado en el almacenamiento.
     *
     * @param  \App\Http\Requests\StoreRecetaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecetaRequest $request) {
        
        $datos = $request->only([
            'titulo',
            'descripcion',
            'duracion',
            'ingredientes',
            'pasos',
            'imagen',
        ]);

        $datos += ['imagen' => NULL];

        if ($request->hasFile('imagen')) {
            // Sube la imagen al directorio indicado en el fichero config/filesystems.php
            $ruta = $request->file('imagen')->store(config('filesystems.recetasImagesDir'));

            // Cogemos solo el nombre para guardarlo en la BDD
            $datos['imagen'] = pathinfo($ruta, PATHINFO_BASENAME);
        }

        $datos['user_id'] = $request->user()->id;
        $datos['ingredientes'] = $request->ingredientes;
        $datos['pasos'] = $request->pasos;

        $receta = Receta::create($datos);

        if (isset($request->categorias)) {            
            foreach ($request->categorias as $categoria) {
                $receta->categorias()->attach($categoria);
            }
        }

        return redirect()->route('recetas.show', $receta->id)
            ->with('success', "Receta $receta->titulo añadida correctamente. Ten en cuenta que la receta no será visible hasta que la apruebe un editor.");
    }

    /**
     * Muestra el recurso especificado.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) {
        
        $receta = Receta::withAvgRating()->findOrFail($id);
        DB::table('recetas')->where('id', '=', $receta->id)->increment('visitas', 1);

        return view('recetas.show', ['receta' => $receta]);
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta) {
        
        $categorias = Categoria::all();
        
        return view('recetas.update', ['receta' => $receta, 'categorias' => $categorias]);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UpdateRecetaRequest  $request
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecetaRequest $request, Receta $receta) {

        $datos = $request->only([
            'titulo',
            'descripcion',
            'duracion',
            'ingredientes',
            'pasos',
            'imagen',
        ]);

        if ($request->user()->cant('update', $receta)) {
            throw new Exception('No tienes permisos para editar esta receta.');
        }

        if ($request->hasFile('imagen')) {
            if ($receta->imagen) {
                $imagenABorrar = config('filesystems.recetasImagesDir').'/'.$receta->imagen;
            }

            $imagenNueva = $request->file('imagen')->store(config('filesystems.recetasImagesDir'));
            $datos['imagen'] = pathinfo($imagenNueva, PATHINFO_BASENAME);
        }

        if ($request->filled('eliminarImagen') && $receta->imagen) {
            $imagenABorrar = config('filesystems.recetasImagesDir').'/'.$receta->imagen;
        }        

        $datos['ingredientes'] = $request->ingredientes;
        $datos['pasos'] = $request->pasos;

        if ($receta->update($datos)) {
            if (isset($imagenABorrar)) {
                Storage::delete($imagenABorrar);
            }
        } else {
            if (isset($imagenNueva)) {
                Storage::delete($imagenNueva);
            }
        }

        if (isset($request->categorias)) {       
            
            if ($receta->categorias()) {
                foreach ($receta->categorias as $categoria) {
                    $receta->categorias()->detach($categoria->id);
                }
            }

            foreach ($request->categorias as $categoria) {
                $receta->categorias()->attach($categoria);
            }
        }
        
        return back()->with('success', "$receta->titulo editada correctamente.");
    }

    /**
     * Muestra el formulario para confirmar la eliminación definitiva del recurso especificado.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, int $id) {
        
        $receta = Receta::withTrashed()->findOrFail($id);        

        if ($request->user()->cant('delete', $receta)) {
            throw new AuthorizationException('No tienes permiso para eliminar definitivamente esta receta.');
        }

        Session::put('returnTo', URL::previous());
        
        return view('recetas.delete', ['receta' => $receta]);
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     * 
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Receta $receta) {
        
        if ($request->user()->cant('destroy', $receta)) {
            throw new AuthorizationException('No tienes permiso para eliminar esta receta.');
        }

        $receta->delete();

        return redirect()
            ->route('home')
            ->with(
                'success',
                "Receta $receta->titulo eliminada correctamente."
            );
    }

    /**
     * Elimina definitivamente el recurso especificado.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function purge(Request $request) {

        $receta = Receta::withTrashed()->findOrFail($request->receta_id);
        $titulo = $receta->titulo;

        if ($request->user()->cant('forceDelete', $receta)) {
            throw new AuthorizationException('No tienes permiso para eliminar definitivamente esta receta.');
        }

        if ($receta->forceDelete() && $receta->imagen) {
            Storage::delete(config('filesystems.recetasImagesDir').'/'.$receta->imagen);
        }

        $redirect = Session::has('returnTo') ?
                    redirect(Session::get('returnTo')) :
                    redirect()->route('home');

        return $redirect->with(
                'success', 
                "Receta $titulo eliminada definitivamente."
            );
    }

    /**
     * Muestra el formulario para confirmar la eliminación del recurso especificado.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, int $id) {

        $receta = Receta::withTrashed()->findOrFail($id);
        $titulo = $receta->titulo;

        if ($request->user()->cant('restore', $receta)) {
            throw new AuthorizationException('No tienes permiso para restaurar esta receta.');
        }

        $receta->restore();

        return back()->with(
            'success', 
            "Receta $titulo restaurada correctamente."
        );
    }

    /**
     * Añadir la receta a favoritos.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function favorite(Request $request) {
        
        $receta = Receta::findOrFail($request->receta_id);
        $user = User::findOrFail($request->user()->id);

        $user->favoritas()->attach($receta);
        $user->update();

        return response([
            'status' => 'OK',
            'results' => [$receta]
        ], 201);
    }

    /**
     * Quitar la receta de favoritos.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function unfavorite(Request $request) {
        
        $receta = Receta::findOrFail($request->receta_id);
        $user = User::findOrFail($request->user()->id);

        $user->favoritas()->detach($receta);
        $user->update();

        return response([
            'status' => 'OK',
            'results' => [$receta]
        ], 201);
    }

    /**
     * Publica la receta.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function publicar(Request $request) {

        $receta = Receta::findOrFail($request->receta_id);
  
        if ($request->user()->cant('publishOrReject', $receta)) {
            throw new AuthorizationException('No tienes permiso para publicar esta receta.');
        }

        $receta->published_at = now();
        $receta->rejected = false;

        $receta->save();

        //NoticiaPublicada::dispatch($noticia, $noticia->user);

        return redirect()->route('recetas.show', $receta->id)
            ->with('success', "Receta $receta->titulo publicada correctamente.");
    }

    /**
     * Rechaza la receta.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function rechazar(Request $request) {

        $receta = Receta::findOrFail($request->receta_id);

        if ($request->user()->cant('publishOrReject', $receta)) {
            throw new AuthorizationException('No tienes permiso para publicar esta receta.');
        }

        $receta->published_at = null;
        $receta->rejected = true;

        $receta->save();
        
        //NoticiaRechazada::dispatch($noticia, $noticia->user);

        return redirect()->route('recetas.show', $receta->id)
        ->with('success', "Receta $receta->titulo rechazada correctamente.");
    }

    /**
     * Devuelve los resultados del formulario de búsqueda.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $palabra
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $palabra = null) {

        $palabra = $request->palabra;

        // appends() para mantener el filtro al pasar de página
        $recetas = Receta::publicadas()
            ->where('titulo', 'like', "%$palabra%")
            ->orWhereHas('categorias', function ($query) use ($palabra) {
                $query->where('titulo', 'like', "%$palabra%");
            })
            ->orderBy('created_at', 'ASC')
            ->paginate(12)
            ->appends(['palabra' => $palabra]);

        return view('recetas.list', [
            'recetas' => $recetas,
            'palabra' => $palabra
        ]);
    }

    /**
     * Devuelve los resultados del formulario de búsqueda las recetas no publicadas.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $palabra
     * @return \Illuminate\Http\Response
     */
    public function searchNoPublicadas(Request $request, $palabra = null) {

        $palabra = $request->palabra;

        // appends() para mantener el filtro al pasar de página
        $recetas = Receta::noPublicadasNoRechazadas()
            ->where('titulo', 'like', "%$palabra%")
            ->orWhereHas('categorias', function ($query) use ($palabra) {
                $query->where('titulo', 'like', "%$palabra%");
            })
            ->orderBy('created_at', 'ASC')
            ->paginate(12)
            ->appends(['palabra' => $palabra]);

        return view('recetas.noPublicadas', [
            'recetas' => $recetas,
            'palabra' => $palabra
        ]);
    }

    /**
     * Devuelve los resultados del formulario de búsqueda de las recetas rechazadas.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $palabra
     * @return \Illuminate\Http\Response
     */
    public function searchRechazadas(Request $request, $palabra = null) {

        $palabra = $request->palabra;

        // appends() para mantener el filtro al pasar de página
        $recetas = Receta::rechazadas()
            ->where('titulo', 'like', "%$palabra%")
            ->orWhereHas('categorias', function ($query) use ($palabra) {
                $query->where('titulo', 'like', "%$palabra%");
            })
            ->orderBy('created_at', 'ASC')
            ->paginate(12)
            ->appends(['palabra' => $palabra]);

        return view('recetas.rechazadas', [
            'recetas' => $recetas,
            'palabra' => $palabra
        ]);
    }
}