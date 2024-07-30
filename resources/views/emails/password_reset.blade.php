<!DOCTYPE html>
<html>
<head>
    <title>Restablecimiento de contraseña</title>
</head>
<body>
    <h1>Restablecimiento de contraseña</h1>
    <p>Haga clic en el siguiente enlace para restablecer su contraseña:</p>
    <a href="{{ url('/submint-new-password/' . $token) }}">Restablecer contraseña</a>
</body>
</html>
