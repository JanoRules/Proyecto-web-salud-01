<?php
header('Content-Type: application/json');
session_start();
include 'conexion.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

$username = $_SESSION['username'];

try {
    // Preparar la consulta para obtener los mensajes del usuario autenticado
    $sql = "SELECT m.id, m.mensaje, m.fecha_envio 
            FROM mensajes m
            JOIN login l ON m.id_usuario = l.id
            WHERE l.username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $mensajes = [];
    while ($row = $result->fetch_assoc()) {
        $row['fecha_envio'] = date('Y-m-d H:i:s', strtotime($row['fecha_envio'])); // Formatear fecha
        $mensajes[] = $row;
    }

    if (empty($mensajes)) {
        echo json_encode(['success' => true, 'mensajes' => [], 'message' => 'No hay mensajes disponibles']);
        exit();
    }

    echo json_encode(['success' => true, 'mensajes' => $mensajes]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    exit();
} finally {
    $stmt->close();
    $conn->close();

}
?>
