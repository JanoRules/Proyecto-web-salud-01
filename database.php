<?php
$host = 'localhost'; // Servidor local (XAMPP)
$db = 'UrgenciaSmart'; // Nombre de la base de datos
$user = 'root'; // Usuario por defecto en XAMPP
$pass = ''; // Contraseña vacía por defecto en XAMPP

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
