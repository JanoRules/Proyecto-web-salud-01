<?php
session_start(); // Iniciar la sesión

$servername = "localhost";
$username = "root";
$password = "";
$database = "base_datos";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    die("Error: Debe iniciar sesión para enviar el formulario.");
}

// Obtener los datos del formulario
$tipoQueja = $_POST['tipoQueja'] ?? null;
$region = $_POST['region'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;

if (empty($tipoQueja) || empty($region) || empty($descripcion)) {
    die("Error: Todos los campos son obligatorios.");
}

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO contacto (tipo_queja, region, descripcion) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $tipoQueja, $region, $descripcion);

if ($stmt->execute()) {
    echo "Su queja ha sido recibida correctamente.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
