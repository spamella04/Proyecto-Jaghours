<!DOCTYPE html>
<html>
<head>
    <title>Verifica tu email</title>
</head>
<body>
    <h1>Verifica tu dirección de correo electrónico</h1>
    <p>Hemos enviado un enlace de verificación a tu correo. Haz clic en el enlace para verificar tu cuenta.</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Reenviar correo de verificación</button>
    </form>
</body>
</html>