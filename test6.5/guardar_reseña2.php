<?php
session_start();
header('Content-Type: application/json');

include 'conexion.php'; // Conexión a la base de datos

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No estás autenticado']);
    exit();
}

$userId = $_SESSION['user_id']; // ID del usuario de la sesión
$reseña = json_decode(file_get_contents('php://input'))->reseña; // Obtén la reseña del cuerpo de la solicitud

$query = "INSERT INTO reseñas (usuario_id, reseña) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $userId, $reseña);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo guardar la reseña']);
}
?>
