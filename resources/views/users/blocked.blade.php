@extends('layouts.app')

@section('title', "LaraChef")

@section('content')

    <div class="container row mt-2 alert alert-danger">
        <div class="col-10 p-4 d-flex flex-row align-items-center">
            <div>
                <p>Has sido <b>bloqueado</b> por un administrador.</p>
                <p>Si no estás de acuerdo o quieres conocer los motivos, contacta mediante el <a href="{{ route('contacto') }}">formulario de contacto</a>.</p>
            </div>
        </div>
        <figure class="col-2">
            <img class="rounded img-fluid" alt="Imagen Usuario bloqueado"
                src="{{ asset('storage/images/template/blocked.png') }}">
            <figcaption class="figure-caption text-center mt-3">Usuario bloqueado</figcaption>
        </figure>
    </div>
    
@endsection