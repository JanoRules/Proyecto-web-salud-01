<?php
$servername = "localhost";
$username = "root"; // Usuario de MySQL
$password = ""; // Contraseña de MySQL
$database = "base_datos"; // Cambia esto al nombre correcto de tu base de datos

try {
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Verifica la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

