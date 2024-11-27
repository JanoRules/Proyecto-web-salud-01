<?php
session_start();

// Si el usuario ya está logueado, redirigir al dashboard
if (isset($_SESSION['username'])) {

    exit();
}

// Verificar si hay un mensaje de error en la sesión
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Limpiar mensaje después de mostrarlo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="Login.css">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    #caja_error {
        display: none;
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
    .visible {
        display: block;
    }
</style>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logo100.png" alt="Ministerio de Salud" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="quick-salud.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="Ultimasnovedades.html">Últimas Novedades</a></li>
                    <li class="nav-item"><a class="nav-link" href="Reseña.html">Reseña</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.html">Contactanos</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ.html">Preguntas Frecuentes</a></li>
                    <li class="nav-item"><a class="nav-link" href="AgendarHora.php">Agenda tu hora</a></li>
                </ul>
                <div class="d-flex">
                    <a class="btn btn-outline-light" href="register.html">Regístrese</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Formulario de inicio de sesión -->
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Mostrar mensaje de error si existe -->
            <?php if (!empty($error_message)): ?>
                <div id="caja_error" class="visible">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success">Iniciar Sesión</button>
            <div class="text-center mt-3">
                <a href="recuperar-contraseña.html" class="text-decoration-none">¿Olvidó su contraseña?</a>
                <p class="mt-3">Si no tiene usuario, <a href="register.html" class="text-decoration-none">Regístrese aquí</a>.</p>
            </div>
        </form>
    </div>
</body>
</html>
