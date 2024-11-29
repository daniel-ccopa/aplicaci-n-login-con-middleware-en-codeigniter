<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 20px;
        }
        p {
            font-size: 20px;
            margin-bottom: 30px;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Bienvenido al Dashboard</h1>
    <p>Hola, <strong><?= esc($username) ?></strong>. Tu rol es: <strong><?= esc($role) ?></strong>.</p>
    <a href="/logout">Cerrar Sesión</a>
</body>
</html>
