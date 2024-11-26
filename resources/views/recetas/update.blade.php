@extends('layouts.app')

@section('title', 'Editar receta')

@section('content')
    <div class="row">
        <div class="col-auto">
            <h2 class="my-3">@yield('title')</h2>
        </div>
    </div>

    <div class="row col-8 offset-2">
        <form action="{{ URL::signedRoute('recetas.update', ['receta' => $receta]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
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
                    <input class="form-control" type="text" name="titulo" id="inputTitulo" value="{{ old('titulo', $receta->titulo) }}">
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
                            <div class="border rounded-start h-100" id="divInputCategorias">
                                @forelse ($receta->categorias as $categoria)
                                    <span class="badge text-bg-secondary rounded-1 fw-normal p-2 ms-1 mt-1" value="{{ $categoria->id }}">{{ $categoria->titulo }}<button class="btn ms-1" onclick="deleteCategoriaElement(event, this)" title="Eliminar categoria"><i class="bi bi-x"></i></button></span>
                                    <input type="hidden" name="categorias[]" value="{{ $categoria->id }}">
                                @empty
                                    
                                @endempty
                            </div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="border rounded-end">
                                <p class="border-bottom ps-2 pb-1 m-0">
                                    <small>Categorías disponibles:</small>
                                </p>
                                <div class="p-2">
                                    @foreach ($categorias as $categoria)
                                        <button class="btn btn-secondary btn-sm mb-1 botonCategoria {{ $receta->hasCategoria($categoria->id) ? 'disabled' : '' }}" data-id-value="{{ $categoria->id }}">{{ $categoria->titulo }}</button>
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
                    <textarea class="form-control" id="inputDescripcion" rows="10" name="descripcion">{{ old('descripcion', $receta->descripcion) }}</textarea>
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
                    <input class="form-control" type="number" name="duracion" id="inputDuracion" value="{{ old('duracion', $receta->duracion) }}">
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
                @forelse ($receta->ingredientes as $ingrediente)
                    @if ($loop->first)
                        <div class="form-group row mb-3 ingredientesInputList" id="ingrediente">
                            <div class="col-sm-2">
                                <label for="inputIngredientes" class="form-label">Ingredientes</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="ingredientes[]" id="inputIngredientes" value="{{ $ingrediente }}">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="form-group row mb-3 ingredientesInputList" id="ingrediente">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="ingredientes[]" id="inputIngredientes" value="{{ $ingrediente }}">
                                    <button class="btn btn-light border input-group-text" onclick="deleteRecetaElement(event, this)" title="Eliminar ingrediente"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    
                @endforelse
                
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
                @forelse ($receta->pasos as $paso)
                    @if ($loop->first)
                        <div class="form-group row mb-3 pasosInputList" id="paso">
                            <div class="col-sm-2">
                                <label for="inputPasos" class="form-label">Pasos</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="pasos[]" id="inputPasos" value="{{ $paso }}">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="form-group row mb-3 pasosInputList" id="paso">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="pasos[]" id="inputPasos" value="{{ $paso }}">
                                    <button class="btn btn-light border input-group-text" onclick="deleteRecetaElement(event, this)" title="Eliminar paso"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    
                @endforelse
                
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

            <div class="form-group row mb-5">
                <div class="col-sm-2">
                    <label class="form-label" for="inputImagen">                        
                        {{ $receta->imagen ? 'Sustituir' : 'Añadir' }} imagen
                    </label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control" type="file" name="imagen" id="inputImagen">
                </div>

                @error('imagen')
                    <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>

            <div class="row justify-content-center align-items-center">
                @if ($receta->imagen)
                    <div class="form-group row mt-3 col-sm-5 offset-1">
                        <label class="form-label text-center" for="inputImagen">Imagen actual:</label>
                        <img class="img-fluid" alt="Imagen {{ $receta->titulo }}"
                            src="{{ asset('storage/'.config('filesystems.recetasImagesDir')).'/'.$receta->imagen }}" >
                    </div>
                    <div class="form-check my-3 col-sm-5">
                        <input type="checkbox" name="eliminarImagen" class="form-check-input" id="inputEliminar">
                        <label for="inputEliminar" class="form-check-label">Eliminar imagen</label>
                    </div>
                    <script>
                        inputEliminar.onchange = function () {
                            inputImagen.disabled = this.checked;
                        }
                    </script>
                @endif
            </div>

            <div class="btn-group d-flex mt-4 mx-auto" role="group" aria-label="Actualizar receta">
                <input type="submit" class="btn btn-primary" role="button" value="Actualizar">
                <input type="reset" class="btn btn-outline-secondary" role="button" value="Restablecer">
            </div>            
        </form>
    </div>
@endsection