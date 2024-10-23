<?php
header('Content-Type: application/json');

// Asumiendo que tienes una conexión a la base de datos ya establecida
$userId = $_SESSION['user_id']; // Suponiendo que tienes una sesión iniciada

$query = "SELECT c.nombre FROM favoritos f JOIN centros_salud c ON f.centro_salud_id = c.id WHERE f.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$favoritos = [];
while ($row = $result->fetch_assoc()) {
    $favoritos[] = $row;
}

echo json_encode(['favoritos' => $favoritos]);
?>
