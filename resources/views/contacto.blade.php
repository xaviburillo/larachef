@php($pagina = Route::currentRouteName())

@extends('layouts.app')

@section('title', "Contactar con LaraChef")

@section('content')

    <div class="row">
        <div class="col-auto">
            <h2 class="my-3">@yield('title')</h2>
        </div>
    </div>
    <div class="container row">
        <form action="{{ route('contacto.email') }}" method="POST" class="col-7 my-3 mx-auto border p-5">
            @csrf
            <div class="form-group row">
                <label for="inputEmail" class="form-label col-sm-2">Email</label>
                <input class="form-control col-sm-10" type="email" name="email" id="inputEmail"
                    value="{{ old('email') }}" placeholder="ejemplo@dominio.com">
                @error('email')
                    <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group row mt-3">
                <label for="inputNombre" class="form-label col-sm-2">Nombre</label>
                <input class="form-control col-sm-10" type="text" name="nombre" id="inputNombre"
                    value="{{ old('nombre') }}" placeholder="Escribe tu nombre aquí...">
                @error('nombre')
                    <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group row mt-3">
                <label for="inputAsunto" class="form-label col-sm-2">Asunto</label>
                <input class="form-control col-sm-10" type="text" name="asunto" id="inputAsunto"
                    value="{{ old('asunto') }}" placeholder="Escribe el asunto aquí...">
                @error('asunto')
                    <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group row mt-3">
                <label for="inputMensaje" class="form-label col-sm-2">Mensaje</label>
                <textarea class="form-control col-sm-10" type="text" name="mensaje" id="inputMensaje" rows="5"  placeholder="Escribe el cuerpo del mensaje aquí...">{{ old('mensaje') }}</textarea>
                @error('mensaje')
                    <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>

            <div class="btn-group d-flex mt-4" role="group" aria-label="Enviar mensaje">
                <input class="btn btn-success" role="button" type="submit" value="Enviar">
                <input class="btn btn-outline-secondary" role="button" type="reset" value="Borrar">
            </div>
        </form>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23887.222267404468!2d2.0819965009112607!3d41.54970212917344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a494fd00277675%3A0x3691e3615821df42!2sSabadell%2C%20Barcelona!5e0!3m2!1ses!2ses!4v1728209977710!5m2!1ses!2ses" 
            loading="lazy" 
            class="col-5 my-3 p-0 border"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
    
@endsection