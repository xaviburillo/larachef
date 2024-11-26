<div class="card receta">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col">
                <h5 class="card-title mt-2 mb-2">
                    <a href="{{ route('recetas.show', ['receta' => $receta->id]) }}" class="text-decoration-none text-reset">{{ $receta->titulo }}</a>
                </h5>
            </div>
            <div class="col-auto d-flex align-items-center">
                @auth
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
                @endauth
            </div>
        </div>
        <div class="row ps-2 mb-2">
            @forelse ($receta->categorias as $categoria)
                <div class="col-auto p-0 ps-1">
                    <span class="badge text-dark">{{ $categoria->titulo }}</span>
                </div>
            @empty
                
            @endforelse
        </div>
        <div class="row small">
            <div class="col">
                <a class="text-decoration-none"
                    href="{{ route('recetas.show', ['receta' => $receta->id]) }}#valoraciones">
                <x-star-rating :rating="$receta->valoraciones_avg_rating" :count="$receta->valoraciones->count()" :extended="false" :tipo="null"/>
            </a>
            </div>
            <div class="col-auto">
                <p class="m-0"> Por:
                    <a class="text-decoration-none"
                        href="{{ route('users.show', ['user' => $receta->user->id]) }}">
                        {{ $receta->user->name }}
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="imagen-container">
            <img class="card-img-top" alt="Imagen receta {{ $receta->titulo }}"
                src="{{ 
                    $receta->imagen ?
                    asset('storage/'.config('filesystems.recetasImagesDir')).'/'.$receta->imagen :
                    asset('storage/'.config('filesystems.recetasImagesDir')).'/default.jpg'
                    }}"
                >
        </div>
        <div class="card-description p-3 pt-1">            
            <p class="card-text p-1 pt-2 mb-2">
                <small>{{ $receta->descripcion }}</small>
            </p>
            <div>
                <a href="{{ route('recetas.show', ['receta' => $receta->id]) }}" class="card-link">Leer más</a>
            </div>
        </div>
    </div>
    <div class="card-footer border-0 bg-white text-body-secondary mb-2">
        <div class="row">
            <div class="col">
                <p class="m-0">{{ $receta->published_at ? Carbon\Carbon::parse($receta->published_at)->diffForHumans(['options' =>  Carbon\Carbon::ONE_DAY_WORDS]) : 'No publicado' }}</p>
            </div>
            <div class="col text-end">
                <p class="m-0">
                    <i class="bi bi-clock pe-1"></i> {{ Carbon\CarbonInterval::minutes($receta->duracion)->cascade()->format('%hh %i\'') }}
                </p>
            </div>
        </div>
    </div>
</div>