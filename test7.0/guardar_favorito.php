<?php
session_start();
include 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

// Verifica si la conexión a la base de datos es exitosa
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
    exit();
}

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado.']);
    exit();
}

// Obtiene el ID del usuario desde la sesión
$userId = $_SESSION['user_id'];

// Obtiene el ID del centro de salud del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Validar si el ID del centro de salud está presente en la solicitud
if (!isset($data->centro_id)) {
    echo json_encode(['success' => false, 'error' => 'ID del centro de salud no proporcionado.']);
    exit();
}

$centroSaludId = $data->centro_id;

// Verifica si el centro de salud ya está en los favoritos del usuario
$checkSql = "SELECT * FROM favoritos WHERE user_id = ? AND centro_salud_id = ?";
$checkStmt = $conexion->prepare($checkSql);
$checkStmt->bind_param("ii", $userId, $centroSaludId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Este centro ya está en tus favoritos.']);
    $checkStmt->close();
    exit();
}
$checkStmt->close();

// Inserta el nuevo favorito en la base de datos
$sql = "INSERT INTO favoritos (user_id, centro_salud_id) VALUES (?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $userId, $centroSaludId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Favorito agregado correctamente']);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al agregar favorito: ' . $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
