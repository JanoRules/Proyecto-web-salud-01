<?php
$host = 'localhost'; // Cambia esto si tu servidor es diferente
$user = 'root'; // Cambia esto a tu nombre de usuario de base de datos
$password = ''; // Cambia esto a tu contraseña de base de datos
$dbname = 'base_datos'; // Cambia esto a tu nombre de base de datos

// Crear conexión
$conexion = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
