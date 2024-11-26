@php($pagina = Route::currentRouteName())

@extends('layouts.app')

@section('title', 'Todas las categorias')

@section('content')
    <div class="row d-flex align-items-end">
        <div class="col-8 offset-2">
            <h2 class="my-3">@yield('title')</h2>
        </div>
    </div>

    <div class="row categoriasDiv d-flex justify-content-evenly">
        <ol class="list-group col">
            @foreach ($categorias as $categoria)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <span class="categoriaContent">{{ $categoria->titulo }}</span>
                    </div>
                    <div class="ms-2 me-auto">
                        <form method="POST" class="d-inline d-none" action="{{ URL::signedRoute('categorias.update', ['categoria' => $categoria->id]) }}">
                            @csrf
                            @method('PUT')
                            
                            <input type="text" name="titulo" class="form-control textoCategoria" autocomplete="off">

                            <div class="mx-auto mt-1 d-flex justify-content-end">
                                <input type="submit" class="btn btn-primary col-auto" role="button" value="Guardar cambios">
                                <input type="reset" class="btn btn-outline-danger col-auto ms-2 cancelarEditCategoria" role="button" value="Cancelar">
                            </div>
                        </form>
                    </div>
                    <div class="d-flex justify-content-between categoriaInfo">
                        <span class="badge text-bg-primary rounded-pill">{{ $categoria->recetas()->count() }}  {{ $categoria->recetas()->count() == 1 ? 'receta' : 'recetas' }}</span>
                        <div class="border-start border-secondary ms-3">
                            @can('update', $categoria)
                                <a href="javascript:void(0);" class="text-decoration-none editCategoria">
                                    <i class="bi bi-pencil text-primary ms-3" title="Editar categoría"></i>
                                </a>
                            @endcan
                            @can('delete', $categoria)
                                <form action="{{ URL::signedRoute('categorias.delete', ['categoria' => $categoria->id]) }}" method="GET" class="d-inline">
                                    @csrf

                                    <a href="javascript:void(0);" onclick="this.closest('form').submit();" class="text-decoration-none">
                                        <i class="bi bi-trash3-fill text-danger ms-1" title="Borrar"></i>
                                    </a>
                                </form>
                            @endcan
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    
        <div class="col-auto">
            <h4 class="mb-3">Nueva categoría</h4>
            <form action="{{ route('categorias.store') }}" method="post">
                @csrf

                <div class="row">
                    <label for="titulo" class="form-label d-none"></label>
                    <div class="col-auto">
                        <input type="text" name="titulo" id="titulo" class="form-control">
                    </div>
                    <div class="col-auto">
                        <input type="submit" value="Añadir" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection