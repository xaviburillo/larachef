@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
<div class="container">
    
    @if (!Auth::user()->email_verified_at)
        <div class="mb-3">
            <x-notVerified/>
        </div>
    @endif
    
    <div class="row justify-content-center">        
        <div class="mb-5">
            <div class="card">
                <div class="card-header">
                    Mi perfil
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table m-0">
                        <tr>
                            <td class="text-secondary">Nombre</td>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary">Email</td>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary">Usuario desde</td>
                            <td>{{ Carbon\Carbon::parse(Auth::user()->created_at)->diffForHumans(['parts' => 2]) }}</td>
                        </tr>
                        
                        <tr>
                            <td class="text-secondary">Verificado</td>
                            <td>
                                @if (Auth::user()->email_verified_at)
                                    <span class="text-success">Estás verificado</span>
                                @else
                                    <span class="text-danger">No estás verificado</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-secondary">Roles</td>
                            <td>
                                @foreach (Auth::user()->roles as $rol)
                                    - {{ $rol->role }}
                                @endforeach
                            </td>
                        </tr>
                        <tr class="border-white">
                            <td class="text-secondary">RRSS</td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <i class="bi bi-facebook" title="Facebook"></i> -
                                            @if (Auth::user()->url_facebook)
                                                <a href="{{ Auth::user()->url_facebook }}">{{ Auth::user()->url_facebook }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="bi bi-twitter-x" title="X"></i> -
                                            @if (Auth::user()->url_twitter)
                                                <a href="{{ Auth::user()->url_twitter }}">{{ Auth::user()->url_twitter }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="bi bi-linkedin" title="LinkedIn"></i> -
                                            @if (Auth::user()->url_linkedin)
                                                <a href="{{ Auth::user()->url_linkedin }}">{{ Auth::user()->url_linkedin }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="bi bi-envelope-at" title="Correo Electrónico"></i> -
                                            @if (Auth::user()->url_email)
                                                <a href="{{ Auth::user()->url_email }}">{{ Auth::user()->url_email }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="bi bi-globe2" title="Sitio Web"></i> -
                                            @if (Auth::user()->url_website)
                                                <a href="{{ Auth::user()->url_website }}">{{ Auth::user()->url_website }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @can('store', App\Models\Receta::class)
            <div class="mb-5"> 
                <h2 class="mb-2">Mis recetas</h2>

                @if($recetas->isNotEmpty())
                    <table class="table border">
                        <thead>
                            <tr>
                                <th scope="col">Titulo</th>
                                <th scope="col">Valoración media</th>
                                <th scope="col">Categorías</th>
                                <th scope="col">Fecha creación</th>
                                <th scope="col">Fecha publicación</th>
                                <th scope="col">Rechazada</th>
                                <th scope="col" class="text-center">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($recetas as $receta)
                                <tr class="{{ !$receta->rejected ? (!$receta->published_at ? 'table-warning' : 'table-success') : 'table-danger'}}">
                                    <td>
                                        <a class="text-black text-decoration-none" href="{{ route('recetas.show', ['receta' => $receta->id]) }}">{{ $receta->titulo }}</a>
                                    </td>
                                    <td>
                                        <x-star-rating :rating="$receta->valoraciones_avg_rating" :count="$receta->valoraciones->count()" :extended="false" :tipo="null"/>
                                    </td>
                                    <td>
                                        @foreach ($receta->categorias as $categoria)
                                            <span class="badge text-bg-secondary">{{ $categoria->titulo }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($receta->created_at)->format('d/m/Y H:m') }}</td>
                                    <td>{{ $receta->published_at ? Carbon\Carbon::parse($receta->published_at)->format('d/m/Y H:m') : 'No publicada' }}</td>
                                    <td>{{ $receta->rejected ? 'Si' : 'No' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('recetas.show', ['receta' => $receta->id]) }}" class="me-1"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('recetas.edit', ['receta' => $receta->id]) }}" class="me-1"><i class="bi bi-pencil"></i></a>
                                        @can('destroy', $receta)
                                            <form action="{{ URL::signedRoute('recetas.destroy', ['receta' => $receta->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <a href="javascript:void(0);" onclick="this.closest('form').submit();" class="text-decoration-none">
                                                    <i class="bi bi-trash3-fill text-danger" title="Borrar"></i>
                                                </a>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No tienes recetas. <a href="{{ route('recetas.create') }}">Puedes crear tu primera receta aquí.</a></p>
                @endif 
            </div> 
        @endcan
        @can('store', App\Models\Receta::class)
            <div class="mb-5"> 
                <h3 class="mb-2">Recetas borradas</h3>

                @if($deletedRecetas->isNotEmpty())
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th scope="col">Titulo</th>
                                <th scope="col">Tema</th>
                                <th scope="col">Fecha creación</th>
                                <th scope="col">Fecha borrado</th>
                                <th scope="col" class="text-center">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($deletedRecetas as $receta)
                                <tr>
                                    <td>
                                        <a class="text-black text-decoration-none" href="{{ route('recetas.show', ['receta' => $receta->id]) }}">{{ $receta->titulo }}</a>
                                    </td>
                                    <td>{{ $receta->tema }}</td>
                                    <td>{{ Carbon\Carbon::parse($receta->created_at)->format('d/m/Y H:m') }}</td>
                                    <td>{{ Carbon\Carbon::parse($receta->deleted_at)->format('d/m/Y H:m') }}</td>
                                    <td>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-auto">
                                                <a class="text-decoration-none text-info d-inline-block"
                                                    href="{{ URL::signedRoute('recetas.restore', ['receta' => $receta->id]) }}">Restaurar</a>
                                            </div>
                                            <div class="col-auto">
                                                <form action="{{ URL::signedRoute('recetas.delete', ['receta' => $receta->id]) }}" method="GET" class="d-inline-block">
                                                    @csrf
                                                    
                                                    <a class="text-decoration-none text-danger d-inline-block" href="javascript:void(0);" onclick="this.closest('form').submit();">
                                                        Eliminar definitivamente
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                @else
                    <p class="m-0">No tienes recetas borradas.</p>
                @endif 
            </div> 
        @endcan
        <div class="mb-5"> 
            <h2 class="mb-2">Recetas favoritas</h2>

            @if(Auth::user()->favoritas->isNotEmpty())
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col">Titulo</th>
                            <th scope="col">Valoración media</th>
                            <th scope="col">Fecha publicación</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($recetasFavoritas as $favorita)
                            <tr>
                                <td>
                                    <a href="{{ route('recetas.show', ['receta' => $favorita->id]) }}">{{ $favorita->titulo }}</a>
                                </td>
                                <td>
                                    <x-star-rating :rating="$favorita->valoraciones_avg_rating" :count="$favorita->valoraciones->count()" :extended="false" :tipo="null"/>
                                </td>
                                <td>{{ $favorita->published_at ? Carbon\Carbon::parse($favorita->published_at)->format('d/m/Y H:m') : 'No publicada' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No tienes recetas favoritas.</p>
            @endif 
        </div>
        
        <div class="mb-5">
            <h2 class="mb-2">Mis valoraciones</h2>
            
            @if($valoraciones->isNotEmpty())
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col">Valoración</th>
                            <th scope="col">Receta</th>
                            <th scope="col">Texto</th>
                            <th scope="col">Fecha creación</th>
                            <th scope="col" class="text-center">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($valoraciones as $valoracion)
                            <tr>
                                <td>
                                    <small>
                                        <x-star-rating :rating="$valoracion->rating" :count="null" :extended="false" :tipo="null"/>
                                    </small>
                                </td>
                                <td>
                                    <a href="{{ route('recetas.show', ['receta' => $valoracion->receta]) }}">{{ $valoracion->receta->titulo }}</a>
                                </td>
                                <td>{{ $valoracion->texto }}</td>
                                <td>{{ Carbon\Carbon::parse($valoracion->created_at)->format('d/m/Y H:m') }}</td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline"
                                        action="{{ URL::signedRoute('valoraciones.purge') }}">
                                        @csrf
                                        @method('DELETE')

                                        <input type="hidden" name="valoracion_id" value="{{ $valoracion->id }}">

                                        <a href="javascript:void(0);" onclick="this.closest('form').submit();" class="text-decoration-none">
                                            <i class="bi bi-trash text-danger" title="Eliminar valoracion"></i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No has valorado ninguna receta.</p>
            @endif         
        </div>
    </div>
</div>
@endsection
