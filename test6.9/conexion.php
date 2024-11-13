<?php
// Datos de conexión a la base de datos
$host = 'localhost';  // o tu host de base de datos
$dbname = 'base_datos';
$username = 'root';
$password = '';

try {
    // Crear una nueva conexión a la base de datos usando PDO
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error a excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: No se pudo establecer la conexión a la base de datos. " . $e->getMessage();
}
?>