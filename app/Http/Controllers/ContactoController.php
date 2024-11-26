<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller {
    
    public function index() {
        return view('contacto');
    }

    public function send(Request $request) {

        $request->validate([
            'email' => 'required|email:rfc'
        ]);

        $mensaje = new \stdClass(); // la \ indica que tendrá que buscar stdClass() desde el root
        $mensaje->asunto = $request->asunto;
        $mensaje->email = $request->email;
        $mensaje->nombre = $request->nombre;
        $mensaje->mensaje = $request->mensaje;

        Mail::to('admin@larachef.com')->send(new Contact($mensaje));

        return redirect()->route('welcome')
            ->with('success', 'Mensaje enviado correctamente.');
    }
}