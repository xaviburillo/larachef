@extends('layouts.app')

@section('title', 'Editar perfil')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-auto">
                        <h2 class="my-4">@yield('title')</h2>
                    </div>
                </div>
                <div class="mb-5">
                    <h3 class="mb-4 col-auto offset-4">Actualizar perfil</h3>
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        @method('patch')

                        <div class="row mb-3">
                            <label for="inputEditarNombre" class="col-md-3 col-form-label text-md-end">Nombre</label>
                            <div class="col-md-6">
                                <input id="inputEditarNombre" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ $user->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-3">
                                <input type="submit" class="btn btn-primary w-100" value="Actualizar">
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="mb-5">
                    <h3 class="mb-4 col-auto offset-4">Cambiar contraseña</h3>
                    <form action="{{ route('password.update') }}" method="post">
                        @csrf

                        <div class="row mb-3">
                            <label for="inputPasswordActual" class="col-md-3 col-form-label text-md-end">Contraseña actual</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="inputPasswordActual" name="current_password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputNuevoPassword" class="col-md-3 col-form-label text-md-end">Nueva contraseña</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="inputNuevoPassword" name="password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPasswordActual_confirm" class="col-md-3 col-form-label text-md-end">Confirmación nueva contraseña</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="inputPasswordActual_confirm" name="password_confirmation">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-3">
                                <input type="submit" class="btn btn-primary w-100" value="Actualizar contraseña">
                            </div>
                        </div>  
                    </form>                  
                </div> --}}

                @can('delete', Auth::user())                    
                    <div class="mb-5">
                        <h3 class="mb-4 col-auto offset-4">Eliminar perfil</h3>
                        <div class="row mb-3">
                            <div class="col-md-7 offset-2">
                                <p>Cuando elimines tu perfil, todos los recursos e información serán borrados permanentemente. Antes de eliminar tu perfil, por favor descarga cualquier data o información que quieras preservar.</p>
                                <button class="btn btn-danger w-100" type="button" data-bs-toggle="modal" data-bs-target="#borrarPerfilModal">Eliminar perfil permanentemente</button>    
                            </div>
                        </div>              

                        <div class="modal fade" id="borrarPerfilModal" tabindex="-1" aria-labelledby="borrarPerfilModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Eliminar perfil</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body px-5">                                      
                                        <form method="post" action="{{ route('profile.destroy') }}">
                                            @csrf
                                            @method('DELETE')

                                            <p class="fw-bolder mt-3">¿Estás seguro de que quieres eliminar tu perfil?</p>
                                            <p>Una vez borres tu perfil, todos los recursos e información serán borrados permanentemente. Por favor, introduce tu contraseña para confirmar que quieres eliminar tu perfil permanentemente.</p>
                    
                                            <div class="row mb-3">
                                                <label for="inputPassword" class="col-md-3 col-form-label text-md-end">Contraseña</label>
                                                <div class="col">
                                                    <input type="password" class="form-control" id="inputNuevoPassword" name="password">
                                                </div>
                                            </div>
                                            <div class="row my-4">
                                                <div class="text-center">
                                                    <div class="btn-group" role="group" >
                                                        <input type="submit" role="button" class="btn btn-danger w-100" value="Eliminar perfil">
                                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>                
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection