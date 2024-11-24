<!DOCTYPE html>
<html>
<head>
    <title>Restablecimiento de Contraseña</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .email-container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            color: #333;
        }
        .content {
            text-align: center;
        }
        .content p {
            margin: 10px 0;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #17A2B8;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Restablecimiento de Contraseña</h1>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Recibimos tu solicitud para restablecer la contraseña de tu cuenta.</p>
            <p>Por favor, haz clic en el botón de abajo para continuar:</p>
            <a href="{{ $resetLink }}" class="button" style = "color: white">Restablecer Contraseña</a>
            <p style="margin-top: 20px;">Este enlace es válido durante los próximos <strong>60 minutos</strong>.</p>
            <p>Si no solicitaste este cambio, ignora este mensaje.</p>
        </div>
        <div class="footer">
            <p>Gracias,<br>Equipo de Soporte</p>
        </div>
    </div>
</body>
</html>
