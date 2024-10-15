// conexion.php
<?php
$servername = "localhost";
$username = "root"; // Cambia esto si usas otro usuario
$password = ""; // contraseña de root SQL
$database = "base_datos";

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
