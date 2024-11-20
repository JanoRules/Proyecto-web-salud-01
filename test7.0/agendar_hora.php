<?php
header('Content-Type: application/json');
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents("php://input"), true);
$idCentro = $data['idCentro'] ?? null;
$fecha = $data['fecha'] ?? null;
$hora = $data['hora'] ?? null;
$idUsuario = $_SESSION['id'];

// Validar que los datos estén completos
if (!$idCentro || !$fecha || !$hora) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit();
}

// Preparar la consulta para insertar en la base de datos
$query = "INSERT INTO agendar_hora (id_centro, fecha, hora, id_usuario) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta', 'error' => $conn->error]);
    exit();
}

$stmt->bind_param("issi", $idCentro, $fecha, $hora, $idUsuario);

// Ejecutar la consulta
$response = ['success' => false];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['message'] = 'Error al insertar en la base de datos';
    $response['error'] = $stmt->error;
}

// Enviar respuesta al cliente
echo json_encode($response);
$stmt->close();
$conn->close();
?>
