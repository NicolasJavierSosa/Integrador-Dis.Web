<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style>
        body {
            background-color: #8A2BE2;
            color: #fff;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .welcome-text {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .gif-placeholder {
            width: 300px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border: 2px dashed #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="welcome-text">
        ¡Bienvenido{{ Auth::check() ? ', ' . (Auth::user()->name ?? 'Usuario') : ' invitado' }}!
    </div>
    <div class="gif-placeholder">
        <img src="https://gifdb.com/images/thumbnail/hand-holding-monkey-spinning-s3tti9y390rs8iud.gif" alt="Bienvenido GIF" style="max-width:100%; max-height:100%;">
    </div>
    <p>
        Aún seguimos trabajando en el proyecto, por favor, vuelve más tarde.
    </p>
</body>
</html>