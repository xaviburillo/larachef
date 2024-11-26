@php($pagina = Route::currentRouteName())

@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <h2 class="my-3">Receta destacada</h2>

    <div class="px-4 pt-5 mb-5 text-center">
        <a href="{{ route('recetas.show', ['receta' => $receta->id]) }}" class="text-decoration-none text-black">
            <h1 class="display-4 fw-bold text-body-emphasis mb-4">{{ $receta->titulo }}</h1>
            <h3 class="fw-light">Creada por:
                <a class="text-decoration-none"
                    href="{{ route('users.show', ['user' => $receta->user->id]) }}">
                    {{ $receta->user->name }}
                </a>
            </h3>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">
                    {{ $receta->descripcion }}
                </p>
                <div class="row mb-4 d-flex justify-content-evenly">
                    <div class="col-auto">
                        <a class="text-decoration-none"
                            href="{{ route('recetas.show', ['receta' => $receta->id]) }}#valoraciones">
                            <x-star-rating :rating="$receta->valoraciones_avg_rating" :count="null" :extended="false" :tipo="null"/>
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock pe-1"></i> {{ Carbon\CarbonInterval::minutes($receta->duracion)->cascade()->format('%hh %i\'') }}
                    </div>
                </div>
            </div>
            <div class="container px-5">
                <img src="{{ $receta->imagen ?
                asset('storage/'.config('filesystems.recetasImagesDir')).'/'.$receta->imagen :
                asset('storage/'.config('filesystems.recetasImagesDir')).'/default.jpg'; }}" 
                class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
            </div>
        </a>
    </div>
@endsection