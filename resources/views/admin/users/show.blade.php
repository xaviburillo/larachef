@extends('layouts.app')

@section('title', "Detalles del usuario $user->name")

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $user->name }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table m-0" id="userTable">
                            <tr>
                                <td class="text-secondary">Id</td>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Nombre</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Usuario desde</td>
                                <td>{{ Carbon\Carbon::parse($user->created_at)->translatedFormat('d/m/y H:m') }}</td>
                            </tr>                            
                            <tr>
                                <td class="text-secondary">Verificado</td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="text-success">Verificado - {{ Carbon\Carbon::parse($user->email_verified_at)->translatedFormat('d/m/y H:m') }}</span>
                                    @else
                                        <span class="text-danger">No verificado</span>
                                    @endif
                                </td>
                            </tr>
                            @can('removeRole', App\Models\User::class)
                                <tr>
                                    <td class="text-secondary">Roles</td>
                                    <td>
                                        @foreach ($user->roles as $rol)
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <span>- {{ $rol->role }}</span>
                                                </div>                                                
                                                @if ($rol->role != 'administrador')
                                                    <div class="col-auto">
                                                        <form action="{{ route('admin.user.removeRole') }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <input type="hidden" name="role_id" value="{{ $rol->id }}">
                                                            <input type="submit" role="button" class="btn btn-danger" value="Quitar rol">
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>                                                
                            @endcan
                            @can('addRole', App\Models\User::class)
                                <tr>
                                    <td class="text-secondary">Añadir rol</td>
                                    <td>                                       
                                        @if ($user->remainingRoles()->isNotEmpty())
                                            <form action="{{ route('admin.user.setRole') }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select class="form-select" name="role_id" id="selectRoles">
                                                            @foreach ($user->remainingRoles() as $rol)
                                                                <option value="{{ $rol->id }}">{{ $rol->role }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-auto">
                                                        <input class="btn btn-success" role="button" type="submit" value="Añadir rol">
                                                    </div>
                                                </div>

                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            </form>
                                        @else
                                            <p>Este usuario tiene todos los roles.</p>
                                        @endif
                                    </td>
                                </tr>
                            @endcan
                            @can('ban', $user)
                                <tr>
                                    <td class="text-secondary">Bloquear</td>
                                    <td>
                                        <a href="{{ URL::signedRoute('admin.user.bloquear', $user->id) }}" class="text-decoration-none pe-1 text-danger" title="Bloquear">
                                            Bloquear <i class="bi bi-hammer"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endcan
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::user()->hasRole(['administrador']))
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <h2 class="mb-2">Valoraciones eliminadas de {{ $user->name}}</h2>
                    @if($valoracionesEliminadas->isNotEmpty())
                        <table class="table border">
                            <thead>
                                <tr>
                                    <th scope="col">Texto</th>
                                    <th scope="col">Noticia</th>
                                    <th scope="col">Fecha creación</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($valoracionesEliminadas as $valoracionEliminada)
                                    <tr>
                                        <td>{{ $valoracionEliminada->texto }}</td>
                                        <td>{{ $valoracionEliminada->receta->titulo }}</td>
                                        <td>{{ Carbon\Carbon::parse($valoracionEliminada->created_at)->format('d/m/Y H:m') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No tiene valoraciones eliminadas.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection