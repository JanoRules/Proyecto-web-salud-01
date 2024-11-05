<?php 
include 'conexion.php';

// Selecciona el mensaje y el nombre del centro de salud correspondiente
$query = "SELECT notificaciones.id, notificaciones.mensaje, notificaciones.timestamp, centros_salud.nombre AS nombre_centro 
          FROM notificaciones 
          JOIN centros_salud ON centros_salud.id = SUBSTRING_INDEX(notificaciones.mensaje, ': ', -1) 
          WHERE visto = FALSE AND timestamp >= (NOW() - INTERVAL 2 MINUTE)";
$result = $conn->query($query);

$notificaciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mensaje = "Actualización de Personas en el " . $row['nombre_centro'];
        $notificaciones[] = ["mensaje" => $mensaje];
    }
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($notificaciones);

$conn->close();
?>

