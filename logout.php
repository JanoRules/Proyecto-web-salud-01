<?php
session_start();
session_destroy();  // Destruir todas las sesiones activas
header("Location: login.html");  // Redirigir al formulario de inicio de sesión
exit();
?>
