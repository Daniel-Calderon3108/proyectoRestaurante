<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>DaCaAr System - Iniciar Sesión</title>
    <link rel="icon" type="image/css" href="../Views/img/icono.jpg">
    <link rel="stylesheet" href="../Views/css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>DaCaAr System - Login</title>
</head>

<body>
    <section class="container_login">
        <div class="login_title">
            <h1>Iniciar Sesión</h1>
        </div>
        <form class="login_body">
            <div class="login_input">
                <input type="text" id="user" class="space" placeholder="Usuario">
            </div>
            <div class="login_input">
                <input type="password" id="password" placeholder="Contraseña">
            </div>
            <div class="login_register">
                <a href="">¿No estas registrado? Registrate Aquí</a>
            </div>
            <div class="login_button">
                <input type="button" id="btn_iniciar_sesion" value="Iniciar Sesión" onclick="validateLogin()">
            </div>
        </form>
    </section>
</body>
<script src="../Views/js/login.js"></script>
</html>