@extends('layouts.mail')

@section('content')
    <dl>
        <dt>Asunto:</dt>
        <dd>
            <h2>{{ $mensaje->asunto }}</h2>
        </dd>            
    </dl>
    <dl>
        <dt>Destinatario: </dt>
        <dd>
            <p class="cursiva">{{ $mensaje->nombre }}
                <a href="mailto:{{ $mensaje->email }}">&lt;{{ $mensaje->email }}&gt;</a>
            </p>
        </dd>
    </dl>
    <dl class="cuerpoMensaje">
        <dt>Mensaje: </dt>
        <dd>
            <p>{{ $mensaje->mensaje }}</p>
        </dd>
    </dl>
@endsection