@extends('layouts.app')

@section('title', "Eliminar receta "$receta->titulo" definitivamente")

@section('content')
    
    <form action="{{ URL::signedRoute('recetas.purge') }}" class="my-3 mx-auto border rounded p-5 col-md-6" method="post">
        @csrf
        @method('DELETE')
        
        <div class="text-center">
            <label class="form-label" for="confirmDelete">¿Estás seguro de querer borrar la receta {{ $receta->titulo }}?</label>
            <p class="text-danger">¡Atención! Esta acción no se puede deshacer.</p>
        </div>

        @if ($receta->imagen)
            <img class="img-fluid" alt="Imagen {{ $receta->titulo }}"
                src="{{ asset('storage/'.config('filesystems.recetasImagesDir')).'/'.$receta->imagen }}" >
        @endif
        
        <input type="hidden" name="receta_id" value="{{ $receta->id }}">

        <div class="btn-group d-flex mt-4" role="group" aria-label="Borrar receta">
            <input class="btn btn-danger col-6" role="button" type="submit" value="Eliminar definitivamente">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary col-6" role="button">Cancelar</a>
        </div>
    </form>

@endsection