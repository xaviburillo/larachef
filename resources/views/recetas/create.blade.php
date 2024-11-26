@php($pagina = Route::currentRouteName())

@extends('layouts.app')

@section('title', 'Crear receta')

@section('content')
    <div class="row">
        <div class="col-auto">
            <h2 class="my-3">@yield('title')</h2>
        </div>
    </div>

    <div class="row col-8 offset-2">
        <form action="{{ route('recetas.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col">
                    <p class="text-secondary text-end">Los campos marcados con <span class="text-danger">*</span> son obligatorios.</p>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-sm-2">
                    <label for="inputTitulo" class="form-label">Título <span class="text-danger">*</span></label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="titulo" id="inputTitulo">
                </div>
                
                @error('titulo')
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10 mt-2">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="form-group row mb-3">
                <div class="col-sm-2">
                    <label for="inputCategorias" class="form-label">Categorías</label>
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <div class="border rounded-start h-100" id="divInputCategorias"></div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="border rounded-end">
                                <p class="border-bottom ps-2 pb-1 m-0">
                                    <small>Categorías disponibles:</small>
                                </p>
                                <div class="p-2">
                                    @foreach ($categorias as $categoria)
                                        <button class="btn btn-secondary btn-sm mb-1 botonCategoria" data-id-value="{{ $categoria->id }}">{{ $categoria->titulo }}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-sm-2">
                    <label for="inputDescripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" id="inputDescripcion" rows="10" name="descripcion"></textarea>
                </div>

                @error('descripcion')
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10 mt-2">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="form-group row mb-3">
                <div class="col-sm-2">
                    <label for="inputDuracion" class="form-label">Duración <span class="text-danger">*</span>
                        <p class="m-0">
                            <small>(en minutos)</small>
                        </p>
                    </label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control" type="number" name="duracion" id="inputDuracion">
                </div>

                @error('duracion')
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="row mb-5">
                <div class="form-group row mb-3 ingredientesInputList" id="ingrediente">
                    <div class="col-sm-2">
                        <label for="inputIngredientes" class="form-label">Ingredientes</label>
                    </div>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input class="form-control" type="text" name="ingredientes[]" id="inputIngredientes">
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10 d-flex justify-content-end">
                        <button class="btn btn-light border addListElement" data-element-type="ingrediente"><i class="bi bi-plus"></i> Añadir ingrediente</button>
                    </div>
                </div>

                @error('ingredientes')
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10 mt-2">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="row mb-5">
                <div class="form-group row mb-3 pasosInputList" id="paso">
                    <div class="col-sm-2">
                        <label for="inputPasos" class="form-label">Pasos</label>
                    </div>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input class="form-control" type="text" name="pasos[]" id="inputPasos">
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10 d-flex justify-content-end">
                        <button class="btn btn-light border addListElement" data-element-type="paso"><i class="bi bi-plus"></i> Añadir paso</button>
                    </div>
                </div>

                @error('pasos')
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10 mt-2">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="form-group row mb-5">
                <div class="col-sm-2">
                    <label class="form-label" for="inputImagen">Imagen</label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control" type="file" name="imagen" id="inputImagen">
                </div>
                
                @error('imagen')
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10 mt-2">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="btn-group d-flex mt-4 mx-auto" role="group" aria-label="Crear receta">
                <input type="submit" class="btn btn-primary" role="button" value="Crear">
                <input type="reset" class="btn btn-outline-secondary" role="button" value="Restablecer">
            </div>            
        </form>
    </div>
@endsection