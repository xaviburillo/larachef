@php($pagina = Route::currentRouteName())

@extends('layouts.app')

@section('title', 'Lista de usuarios')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-end mb-2">
        <form action="{{ route('admin.users.search') }}" method="GET" class="row">
            <input name="name" type="text" class="col form-control me-2 mb-3" placeholder="Nombre" value="{{ old('name') ?? '' }}">
            <input name="email" type="text" class="col form-control me-2 mb-3" placeholder="Email" value="{{ old('email') ?? '' }}">
            <input type="submit" class="col btn btn-primary me-2 mb-3" value="Buscar">
            <a href="{{ route('admin.users') }}" class="col btn btn-outline-primary mb-3" role="button">Quitar filtro</a>
        </form>
        {{ $users->links() }}
    </div>

    <div>
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr class="text-center" style="font-size: 0.9em;">
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha de alta</th>
                    <th>Nº recetas</th>
                    <th>Roles</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td class="text-center">#{{ $u->id }}</td>
                        <td>
                            <a class="text-decoration-none" href="{{ route('admin.user.show', $u->id) }}">{{ $u->name }}</a>
                        </td>
                        <td>
                            <a class="text-decoration-none" href="mailto:{{ $u->email }}">{{ $u->email }}</a>
                        </td>
                        <td class="text-center">{{ Carbon\Carbon::parse($u->created_at)->translatedFormat('d/m/y H:m') }}</td>
                        <td class="text-center">{{ $u->recetas()->count() }}</td>
                        <td class="text-center small">
                            @foreach ($u->roles as $rol)
                                <span {{ $loop->remaining == 0 ? : 'class="me-2"' }}>{{ ucfirst($rol->role) }}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a href="{{ route('users.show', $u->id) }}" class="text-decoration-none pe-1">
                                <i class="bi bi-person-circle text-dark" title="Ver perfil"></i>
                            </a>
                            <a href="{{ route('admin.user.show', $u->id) }}" class="text-decoration-none pe-1">
                                <i class="bi bi-file-bar-graph text-info" title="Gestionar usuario"></i>
                            </a>
                            @can('ban', $u)
                                <a href="{{ URL::signedRoute('admin.user.bloquear', $u->id) }}" class="text-decoration-none pe-1" title="Bloquear">
                                    <i class="bi bi-hammer text-danger"></i>
                                </a>
                            @endcan
                            @can('unban', $u)
                                <a href="{{ URL::signedRoute('admin.user.desbloquear', $u->id) }}" class="text-decoration-none pe-1" title="Desbloquear">
                                    <i class="bi bi-emoji-smile-fill text-success"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-between align-items-start">
        <p>Mostrando {{ $users->count()." de ".$users->total(); }}.</p>
        {{ $users->links(); }}
    </div>
</div>
@endsection