<?php
session_start(); // Iniciar sesión para acceder al rut del usuario
include 'conexion.php'; // Incluir archivo de conexión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    die("Error: No has iniciado sesión.");
}

$rut = $_SESSION['rut']; // Obtener el rut del usuario autenticado

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $centro_salud = $_POST['centro_salud'];

    // Consulta SQL para insertar las preferencias del usuario
    $sql = "INSERT INTO preferencias_salud (rut, tipo_centro_salud) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error al preparar la consulta: ' . $conn->error);
    }

    $stmt->bind_param("ss", $rut, $centro_salud);

    if ($stmt->execute()) {
        echo "Preferencias guardadas con éxito.";
        header("Location: dashboard.html"); // Redirigir al dashboard después de guardar
    } else {
        echo "Error al guardar las preferencias: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>