<?php
header('Content-Type: application/json');
session_start();
include 'conexion.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

$idUsuario = $_SESSION['id'];

try {
    // Preparar la consulta para obtener los mensajes del usuario autenticado
    $sql = "SELECT mensaje, fecha_envio FROM mensajes WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $mensajes = [];
    while ($row = $result->fetch_assoc()) {
        $row['fecha_envio'] = date('Y-m-d H:i:s', strtotime($row['fecha_envio'])); // Formatear fecha
        $mensajes[] = $row;
    }

    // Si no hay mensajes, enviar un mensaje adecuado
    if (empty($mensajes)) {
        echo json_encode(['success' => true, 'mensajes' => [], 'message' => 'No hay mensajes disponibles']);
        exit();
    }

    // Devolver los mensajes encontrados
    echo json_encode(['success' => true, 'mensajes' => $mensajes]);

} catch (Exception $e) {
    // Manejar errores generales
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    exit();
} finally {
    $stmt->close();
    $conn->close();
}
?>
