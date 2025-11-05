<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de verificación - Funkystep</title>
    <style>
        body {
            font-family: 'Funnel Display', 'Arial', sans-serif;
            background-color: #f4f4f6;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e1e1e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .header {
            background: #530303;
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 1.8rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .content {
            padding: 40px 30px;
            text-align: center;
        }

        .content p {
            font-size: 1rem;
            line-height: 1.7;
            color: #444;
            margin-bottom: 1em;
        }

        .code-box {
            display: inline-block;
            background: #f5f5f5;
            border: 1px solid #ccc;
            padding: 16px 36px;
            border-radius: 8px;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: 4px;
            color: #111;
            margin: 25px 0;
        }

        .footer {
            background: #fafafa;
            text-align: center;
            color: #777;
            font-size: 0.85rem;
            padding: 18px;
            border-top: 1px solid #eee;
        }

        a {
            color: #530303;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Pequeño detalle visual profesional */
        .divider {
            width: 60px;
            height: 4px;
            background-color: #530303;
            margin: 0 auto 30px;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>FUNKYSTEP</h1>
        </div>

        <div class="content">
            <div class="divider"></div>
            <p>Hola <strong>{{ $user->name }}</strong>,</p>
            <p>Gracias por usar Funkystep. Para continuar con tu proceso de verificación, usa el siguiente código:</p>

            <div class="code-box">{{ $user->two_factor_code }}</div>

            <p>Este código expirará en <strong>10 minutos</strong>.</p>
            <p>Si no solicitaste este código, puedes ignorar este mensaje.</p>
        </div>

        <div class="footer">
            © {{ date('Y') }} Funkystep — Todos los derechos reservados.  
        </div>
    </div>
</body>
</html>
