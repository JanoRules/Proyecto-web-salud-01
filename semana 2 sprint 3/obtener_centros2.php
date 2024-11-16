<?php
header('Content-Type: application/json');
include 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

$query = "SELECT id, nombre, atencion, tipo, horario FROM centros_salud";
$result = $conn->query($query);

$centros = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $centros[] = $row;
    }
}

echo json_encode($centros);
?>
