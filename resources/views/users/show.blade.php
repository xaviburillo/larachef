@extends('layouts.app')

@section('title', "Perfil de $user->name")

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">{{ $user->name }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table m-0" id="userTable">
                            <tr>
                                <td class="text-secondary">Usuario desde</td>
                                <td>{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Recetas subidas</td>
                                <td>{{ $user->recetas()->count() }} {{ $user->recetas()->count() == 1 ? 'receta' : 'recetas' }}</td>
                            </tr>
                            @if ($user->recetas()->count() > 0)
                                <tr>
                                    <td class="text-secondary">Valoración media</td>
                                    <td><x-star-rating :rating="$userRating" :count="null" :extended="false" :tipo="''"/></td>
                                </tr>
                            @endif
                            <tr class="border-white">
                                <td class="text-secondary">RRSS</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <i class="bi bi-facebook" title="Facebook"></i> -
                                                @if ($user->url_facebook)
                                                    <a href="{{ $user->url_facebook }}">{{ $user->url_facebook }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="bi bi-twitter-x" title="X"></i> -
                                                @if ($user->url_twitter)
                                                    <a href="{{ $user->url_twitter }}">{{ $user->url_twitter }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="bi bi-linkedin" title="LinkedIn"></i> -
                                                @if ($user->url_linkedin)
                                                    <a href="{{ $user->url_linkedin }}">{{ $user->url_linkedin }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="bi bi-envelope-at" title="Correo Electrónico"></i> -
                                                @if ($user->url_email)
                                                    <a href="{{ $user->url_email }}">{{ $user->url_email }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="bi bi-globe2" title="Sitio Web"></i> -
                                                @if ($user->url_website)
                                                    <a href="{{ $user->url_website }}">{{ $user->url_website }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row mt-5">
                    <h3 class="mb-3">Recetas de {{ $user->name }}</h3>
                    @forelse ($recetas as $receta)
                        <div class="col-4 mb-3">
                            <x-receta-card :receta="$receta"/>
                        </div>
                    @empty
                        <div>
                            <p>El usuario aún no tiene recetas publicadas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection