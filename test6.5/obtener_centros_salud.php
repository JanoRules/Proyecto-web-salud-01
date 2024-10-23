<?php
require 'conexion.php';

$lat = $_GET['lat'];
$lng = $_GET['lng'];

// Consulta para obtener los centros cercanos
$query = "SELECT id, nombre, latitud AS lat, longitud AS lng FROM centros_salud 
          WHERE ST_Distance_Sphere(point(latitud, longitud), point(?, ?)) < 5000"; // Cambia el radio si es necesario

$stmt = $conn->prepare($query);
$stmt->bind_param("dd", $lat, $lng);
$stmt->execute();
$result = $stmt->get_result();

$centros = [];
while ($row = $result->fetch_assoc()) {
    $centros[] = $row;
}

echo json_encode(['centros' => $centros]);
?>
