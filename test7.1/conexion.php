<?php
$host = "localhost";
$username = "root";
$password = ""; // Cambia si usas una contraseña
$database = "base_datos";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
