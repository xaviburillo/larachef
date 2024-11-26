@php($pagina = Route::currentRouteName())

@extends('layouts.app')

@section('title', 'Todas las recetas')

@section('content')
    <div class="row d-flex align-items-end">
        <div class="col-auto">
            <h2 class="my-3">@yield('title')
                {{ isset($palabra) ? " - Resultados de la búsqueda \"$palabra\"" : '' }}
            </h2>
        </div>
        @isset($palabra)
            <div class="col-auto">
                <a href="{{ route('recetas.index') }}" class="d-block mb-3 py-1" role="button">Quitar filtro</a>
            </div>
        @endisset
    </div>
    <div class="row d-flex justify-content-between align-items-end">
        <div class="col">
            <x-buscador :action="route('recetas.search')" :method="'GET'" :palabra="$palabra ?? ''"/>
        </div>
        <div class="col-auto">
            {{ $recetas->links() }}
        </div>
    </div>

    <div class="row">
        @forelse ($recetas as $receta)
            <div class="col-4 mb-3">
                <x-receta-card :receta="$receta"/>
            </div>
        @empty
            <div>
                <p>Aún no hay recetas publicadas.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-between align-items-start">
        <div class="col-auto">
            <p>Mostrando {{ $recetas->count()." de ".$recetas->total() }}.</p>
        </div>
        <div class="col-auto">
            {{ $recetas->links() }}
        </div>
    </div>
@endsection