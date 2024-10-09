<?php
include 'conexion.php'; // Conectar a la base de datos

$sql = "SELECT nombre, producto, calificacion, reseña, fecha FROM reseñas ORDER BY fecha DESC"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $reseñas = [];
    while ($row = $result->fetch_assoc()) {
        $reseñas[] = [
            'nombre' => $row['nombre'],
            'producto' => $row['producto'],
            'calificacion' => $row['calificacion'],
            'reseña' => $row['reseña'],
            'fecha' => $row['fecha']
        ];
    }
    echo json_encode($reseñas);
} else {
    echo json_encode([]);
}

$conn->close();
?>
