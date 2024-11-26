<div class="mb-3">
    <div class="row border rounded receta-item">
        <img class="col-md-2 rounded-start-2 p-0" alt="Imagen receta {{ $receta->titulo }}"
            src="{{ 
                $receta->imagen ?
                asset('storage/'.config('filesystems.recetasImagesDir')).'/'.$receta->imagen :
                asset('storage/'.config('filesystems.recetasImagesDir')).'/default.jpg'
                }}">
        <div class="col-md-10 justify-content-between py-3 pe-3">
            <div>
                <div class="row">
                    <div class="col">
                        <h5 class="fw-bolder">
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
                <p class="mb-1 text-body-secondary">{{ $receta->tema }}</p>
                <p class="mb-0">{{ $receta->descripcion }}</p>
            </div>
        </div>
    </div>
    <div class="row d-flex flex-row-reverse">
        <div class="col-auto offset-3 border rounded rounded-top-0 receta-item-info">
            <div class="row  p-2 text-center">
                @if ($section == 'publishOrReject')
                    @can('publishOrReject', $receta)      
                        <div class="col-auto d-flex align-items-center justify-content-center">
                            <form action="{{ route('recetas.publicar') }}" method="post">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="receta_id" value="{{ $receta->id }}">

                                <input type="submit" class="btn btn-primary me-3" role="button" value="Publicar">
                            </form>
                            <form action="{{ route('recetas.rechazar') }}" method="post">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="receta_id" value="{{ $receta->id }}">
                                
                                <input type="submit" class="btn btn-outline-danger me-3" role="button" value="Rechazar">
                            </form>
                        </div>
                    @endcan
                @endif        

                <div class="col-auto">
                    <p class="m-0">
                        <small>Creado por: {{ $receta->user->name }}</small>
                    </p>
                    <p class="m-0">
                        <small>{{ Carbon\Carbon::parse($receta->created_at)->format('d/m/Y H:m:s') }} ({{ Carbon\Carbon::parse($receta->created_at)->diffForHumans() }})</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>