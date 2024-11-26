@extends('layouts.mail')

@section('content')    
    <h1>¡Felicidades!</h1>
    <h3>¡Tu receta <a href="{{ route('recetas.show', ['receta' => $receta->id]) }}" class="">{{ $receta->titulo }}</a> en LaraChef ha sido aprobada!</h3>
    <p>Junto con esta, ya son {{ $count }} las recetas que has publicado. ¡Sigue así!</p>
@endsection