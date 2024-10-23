<?php
session_start();
include 'conexion.php'; // Asegúrate de que estás conectado a la base de datos

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login2.html"); // Redirige si no está autenticado
    exit();
}

// Obtén el ID del usuario
$userId = $_SESSION['user_id'];

// Consulta para obtener los favoritos del usuario
$sql = "SELECT cs.* FROM favoritos f JOIN centros_salud cs ON f.centro_salud_id = cs.id WHERE f.user_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Mostrar los centros de salud favoritos
echo "<h2>Mis Centros de Salud Favoritos</h2>";
while ($centro = $result->fetch_assoc()) {
    echo "<div>{$centro['nombre']} - {$centro['direccion']}</div>"; // Cambia según tus columnas
}

$stmt->close();
$conexion->close();
?>
