<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LaraChef') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'LaraChef') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        @php($pagina = Route::currentRouteName())

                        <li class="nav-item">
                            <a class="nav-link {{ $pagina=='recetas.list' ? 'active' : '' }}" href="{{ route('recetas.list') }}">Todas las recetas</a>
                        </li>

                        @auth
                            @can('store', App\Model\Receta::class)
                                <li class="nav-item">
                                    <a class="nav-link {{ $pagina=='recetas.create' ? 'active' : '' }}" href="{{ route('recetas.create') }}">Crear receta</a>
                                </li>
                            @endcan

                            @can('publishOrReject', App\Model\Receta::class)                         
                                <li class="nav-item">
                                    <a class="nav-link {{ $pagina=='recetas.noPublicadas' ? 'active' : '' }}" href="{{ route('recetas.noPublicadas') }}">Recetas por publicar</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link {{ $pagina=='recetas.rechazadas' ? 'active' : '' }}" href="{{ route('recetas.rechazadas') }}">Recetas rechazadas</a>
                                </li>
                            @endcan
                            
                            @can('manage', App\Model\Categoria::class)
                                <li class="nav-item">
                                    <a href="{{ route('categorias.index') }}" class="nav-link {{ $pagina=='categorias.index' ? 'active' : '' }}">Categorias</a>
                                </li>
                            @endcan
                            
                            @can('manage', App\Model\User::class)
                                <li class="nav-item">
                                    <a href="{{ route('admin.users') }}" class="nav-link {{ $pagina=='admin.users' || $pagina=='admin.users.search' ? 'active' : '' }}">Gestión de usuarios</a>
                                </li>
                            @endcan
                        @endauth

                        <li class="nav-item">
                            <a class="nav-link {{ $pagina=='contacto' ? 'active' : '' }}" href="{{ route('contacto') }}">Contacto</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registro</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <small>
                                            Mi perfil
                                        </small>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <small>
                                            Editar perfil
                                        </small>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <small>
                                            Cerrar sesión
                                        </small>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container py-4">

            @if (session('success'))
                <x-alert type="success" message="{{ session('success') }}">
                </x-alert>
            @endif

            @if ($errors->any())
                <x-alert type="danger" message="Se han producido errores:">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            @yield('content')
        </main>

        <footer class="page-footer font-small p-4 bg-light text-center mt-auto">
            @section('footer')
                <p class="m-0">Aplicación creada por Xavi Burillo. Desarrollada haciendo uso de <b>Laravel v8.5</b> y <b>Bootstrap v5.3.3</b>.</p>
            @show
        </footer>
    </div>
</body>
</html>
