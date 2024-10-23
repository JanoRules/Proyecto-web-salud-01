<?php
session_start(); // Inicia la sesión

// Elimina todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy(); // Destruye la sesión

// Redirigir al usuario a la página de inicio de sesión
header("Location: login2.html");
exit();
?>
