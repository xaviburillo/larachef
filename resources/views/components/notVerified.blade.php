<div class="alert alert-primary">
    <b>Atención: No has verificado el e-mail!</b> Antes de poder continuar, por favor, confirma tu correo electrónico con el enlace que te hemos enviado. Si no has recibido el email, 
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">pulsa aquí para que te enviemos otro</button>.
    </form>
</div>