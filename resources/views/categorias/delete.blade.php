@extends('layouts.app')

@section('title', "Eliminar categoria ".$categoria->titulo." definitivamente")

@section('content')
    
    <form action="{{ URL::signedRoute('categorias.purge') }}" class="my-3 mx-auto border rounded p-5 col-md-6" method="post">
        @csrf
        @method('DELETE')
        
        <div class="text-center">
            <label class="form-label" for="confirmDelete">¿Estás seguro de querer borrar la categoria {{ $categoria->titulo }}?</label>
            <p class="text-danger">¡Atención! Esta acción no se puede deshacer.</p>
        </div>
        
        <input type="hidden" name="categoria_id" value="{{ $categoria->id }}">

        <div class="btn-group d-flex mt-4" role="group" aria-label="Borrar categoria">
            <input class="btn btn-danger col-6" role="button" type="submit" value="Eliminar definitivamente">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary col-6" role="button">Cancelar</a>
        </div>
    </form>

@endsection