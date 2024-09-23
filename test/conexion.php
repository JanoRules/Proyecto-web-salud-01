<?php
$servername = "localhost";
$username = "root"; // Cambia esto si usas otro usuario
$password = "janorules567"; // Cambia esto a la contraseña de root si la tienes
$database = "base_datos";

try {
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Verifica la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    echo "Conexión exitosa";
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
