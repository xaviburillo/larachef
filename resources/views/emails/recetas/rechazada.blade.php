@extends('layouts.mail')

@section('content')    
    <h1>¡Maldición!</h1>
    <h3>¡Tu receta <a href="{{ route('recetas.show', ['receta' => $receta->id]) }}" class="">{{ $receta->titulo }}</a> en LaraChef ha sido rechazada!</h3>
    <p>Si no estás de acuerdo, recuerda que puedes usar el <a href="{{ route('contacto') }}">formulario de contacto</a> para contactar con el equipo de LaraChef.</p>
@endsection