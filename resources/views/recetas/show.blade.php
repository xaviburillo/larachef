@extends('layouts.app')

@section('title', $receta->titulo )

@section('content')
    <div>
        <div class="col-6 offset-3">
            <img class="card-img-top mb-3" alt="Imagen receta {{ $receta->titulo }}"
                        src="{{ 
                            $receta->imagen ?
                            asset('storage/'.config('filesystems.recetasImagesDir')).'/'.$receta->imagen :
                            asset('storage/'.config('filesystems.recetasImagesDir')).'/default.jpg'
                            }}"
                        >
        </div>
        <div class="mb-4">
            <div class="row d-flex align-items-center">
                <div class="col">
                    <h1>{{ $receta->titulo }}</h1>
                </div>
                <div class="col-auto d-flex align-items-center">
                    @auth
                        <div class="me-2">
                            @if (Auth::user()->isRecetaFavorita($receta->id))
                                <form action="{{ route('recetas.unfavorite') }}" method="post">
                                    <input type="hidden" name="receta_id" value="{{ $receta->id }}">
                                    <i class="bi bi-heart-fill text-danger fs-5 corazonInput" title="Favorito"></i>
                                </form>
                            @else
                                <form action="{{ route('recetas.favorite') }}" method="post">
                                    <input type="hidden" name="receta_id" value="{{ $receta->id }}">
                                    <i class="bi bi-heart text-danger fs-5 corazonInput" title="Favorito"></i>
                                </form>
                            @endif
                        </div>
                        <div>
                            @can('update', $receta)
                                <a href="{{ route('recetas.edit', ['receta' => $receta->id]) }}" class="me-1"><i class="bi bi-pencil fs-5" title="Editar"></i></a>
                            @endcan
                            @can('delete', $receta)
                                <form action="{{ URL::signedRoute('recetas.destroy', ['receta' => $receta->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <a href="javascript:void(0);" onclick="this.closest('form').submit();" class="text-decoration-none">
                                        <i class="bi bi-trash3-fill text-danger fs-5" title="Borrar"></i>
                                    </a>
                                </form>
                            @endcan
                        </div>
                    @endauth
                </div>
            </div>
            <div>
                @forelse ($receta->categorias as $categoria)
                    <span class="badge text-dark">{{ $categoria->titulo }}</span>
                @empty
                    
                @endforelse
            </div>
        </div>
        <div class="row mb-2 d-flex justify-content-between">
            <div class="col-auto">
                <p class="m-0">Creada por: <a href="{{ route('users.show', ['user' => $receta->user->id]) }}">{{ $receta->user->name }}</a></p>
            </div>
            <div class="col-auto">
                <div class="row">
                    <small>
                        <a href="#valoraciones" class="text-decoration-none">
                            <x-star-rating :rating="$receta->valoraciones_avg_rating" :count="$receta->valoraciones->count()" :extended="true" :tipo="'valoraciones'"/>
                        </a>
                    </small>
                </div>
                @auth
                    @if (Auth::user()->hasRole(['administrador']))
                        <p class="m-0">Creada en: {{ Carbon\Carbon::parse($receta->created_at)->format('d/m/Y') }} ({{ Carbon\Carbon::parse($receta->created_at)->diffForHumans() }})</p>
                        <p class="m-0">Actualizada en: {{ Carbon\Carbon::parse($receta->updated_at)->format('d/m/Y') }} ({{ Carbon\Carbon::parse($receta->updated_at)->diffForHumans() }})</p>
                        <p class="m-0">Publicada en: {{ $receta->published_at ? (Carbon\Carbon::parse($receta->updated_at)->format('d/m/Y')." (".Carbon\Carbon::parse($receta->updated_at)->diffForHumans().")") : '- No publicada' }}</p>
                    @endif
                @endauth
            </div>  
        </div>
        <div class="row mb-5 d-flex justify-content-between">
            <div class="col-auto">
                @if (Auth::check() && Auth::user()->hasRole(['editor', 'administrador']))
                    <h6>Estado:
                        @if ($receta->rejected)
                            Rechazada
                        @elseif(!$receta->published_at)
                            No publicada
                        @else
                            Publicada
                        @endif
                    </h6>
                @endif
            </div>
            <div class="col-auto">
                {{ $receta->usuariosFavoritos()->count() }} {{ $receta->usuariosFavoritos()->count() == 1 ? 'favorito' : ' favoritos' }}
            </div>
        </div>
        <div>
            <h3>Descripción</h3>
            <p>{{ $receta->descripcion }}</p>
        </div>
        <div>
            <h3>Duración</h3>
            <p><i class="bi bi-clock pe-1"></i> {{ Carbon\CarbonInterval::minutes($receta->duracion)->cascade()->forHumans() }}</p>
        </div>
        <div>
            <h3>Ingredientes</h3>
            <ul>
                @if ($receta->pasos != null)
                    @forelse ($receta->ingredientes as $ingrediente)
                        @if ($ingrediente != '')
                            <li>{{ $ingrediente }}</li>
                        @elseif($loop->last)
                            <p>Sin ingredientes. Añadir los ingredientes y sus cantidades es aconsejable para que tu receta sea publicada.</p>
                        @endif 
                    @empty

                    @endforelse
                @endif
            </ul>
        </div>          
        <div>
            <h3>Pasos</h3> 
            <ol>
                @if ($receta->pasos != null)
                    @forelse ($receta->pasos as $paso)
                        @if ($paso != '')
                            <li>{{ $paso }}</li>
                        @elseif($loop->last)
                            <p>Sin pasos. Añadir los pasos es aconsejable para que tu receta sea publicada.</p>
                        @endif 
                    @empty

                    @endforelse
                @endif
            </ol>
        </div>   
        <section class="mt-5" id="valoraciones">
            <div class="accordion" id="valoracionesAccordion">
                <div class="accordion-item">
                    <h4 class="accordion-header">
                        <button class="accordion-button bg-secondary-subtle text-black" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="false" aria-controls="collapse">
                            Valoraciones ({{ $receta->valoraciones->count() }})
                        </button>
                    </h4>
                    <div id="collapse" class="accordion-collapse collapse show" data-bs-parent="#valoracionesAccordion">
                        <div class="accordion-body p-0"> 
                            @forelse ($receta->valoraciones as $valoracion)
                                <div class="{{ !$loop->last ? 'border-bottom' : '' }} p-3 valoracion">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col">
                                            @if (Auth::user() && Auth::user()->isValoracionOwner($valoracion))
                                                <h6 class="fw-bolder text-success">{{ $valoracion->user->name }} (Tú)</h6>
                                            @else
                                                <h6 class="fw-bolder">{{ $valoracion->user->name }}</h6>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <x-star-rating :rating="$valoracion->rating" :count="null" :extended="false" :tipo="''"/>
                                        </div>
                                        <div class="col-auto">
                                            <small>
                                                <p class="mb-2">Fecha de publicación: {{ Carbon\Carbon::parse($valoracion->created_at)->format('d/m/Y') }} ({{ Carbon\Carbon::parse($valoracion->created_at)->diffForHumans() }})</p>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="mt-3 valoracionContent">{{ $valoracion->texto }}</p>
                                        </div>
                                        <div class="col-auto pe-4">
                                            @can('update', $valoracion)
                                                <div class="col-auto pb-1">
                                                    <a href="javascript:void(0);" class="text-decoration-none editValoracion">
                                                        <i class="bi bi-pencil text-primary" title="Editar valoracion"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('destroy', $valoracion)
                                                <div class="col-auto pb-1">                                                
                                                    <form method="POST" class="d-inline"
                                                        action="{{ Auth::user()->hasRole(['administrador']) ?
                                                            URL::signedRoute('valoraciones.destroy', ['valoracion' => $valoracion->id]) :
                                                            URL::signedRoute('valoraciones.purge') }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <input type="hidden" name="valoracion_id" value="{{ $valoracion->id }}">

                                                        <a href="javascript:void(0);" onclick="this.closest('form').submit();" class="text-decoration-none">
                                                            <i class="bi bi-trash text-danger" title="Eliminar valoracion"></i>
                                                        </a>
                                                    </form>
                                                </div>
                                            @endcan
                                        </div>                                            
                                    </div>

                                    @can('update', $valoracion)
                                        <form method="POST" class="d-inline d-none" action="{{ URL::signedRoute('valoraciones.update', ['valoracion' => $valoracion->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            
                                            <textarea name="texto" class="form-control textoValoracion my-2" autocomplete="off"></textarea>

                                            <div class="mx-auto d-flex justify-content-end">
                                                <input type="submit" class="btn btn-primary col-auto" role="button" value="Guardar cambios">
                                                <input type="reset" class="btn btn-outline-danger col-auto ms-2 cancelarEditValoracion" role="button" value="Cancelar">
                                            </div>
                                        </form>
                                    @endcan
                                </div>
                            @empty
                                <p class="p-3 m-0">Aún no hay ninguna valoración. ¡No pierdas la oportunidad de ser el primero en valorar esta receta!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-5">
                <h3 class="row col-8 offset-2 mb-5">Valorar receta</h3>
                <div class="row col-8 offset-2">
                    @can('store', App\Models\Valoracion::class)
                        <form action="{{ route('valoraciones.store') }}" method="post">
                            @csrf

                            <input type="hidden" name="receta_id" value="{{ $receta->id }}">

                            <div class="row mb-3 d-flex justify-items-center">
                                <div class="col-md-3">
                                    <label for="inputNota" class="form-label">Nota</label>
                                </div>
                                <div class="col">
                                    <div id="estrellasInput">
                                        <i class='bi bi-star-fill estrellaInput' data-value="1"></i>
                                        <i class='bi bi-star-fill estrellaInput' data-value="2"></i>
                                        <i class='bi bi-star-fill estrellaInput' data-value="3"></i>
                                        <i class='bi bi-star estrellaInput' data-value="4"></i>
                                        <i class='bi bi-star estrellaInput' data-value="5"></i>
                                    </div>
                                    <input type="hidden" name="rating" value="3">
                                </div>
                                @error('nota')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="inputTexto" class="form-label">Comentario</label>
                                </div>
                                <div class="col">
                                    <textarea class="form-control" id="inputTexto" rows="5" name="texto" placeholder="Introduce tu valoracion aquí..."></textarea>
                                </div>
                                @error('texto')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mt-2 mx-auto d-flex justify-content-end">
                                <input type="submit" class="btn btn-primary col-auto" role="button" value="Publicar valoración">
                            </div>
                        </form>
                    @else
                        <p class="text-center">Para valorar una receta debes estar registrado. <a href="{{ route('register') }}">Haz click aquí para registrarte.</a></p>
                        <p class="text-center">O puedes <a href="{{ route('login') }}">iniciar sesión.</a></p>
                    @endcan
                </div>
            </div>
        </section>
    </div>
@endsection