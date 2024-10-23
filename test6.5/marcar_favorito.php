<?php
require 'conexion.php';

session_start();
$userId = $_SESSION['user_id']; // Suponiendo que tienes una sesión iniciada
$centroId = $_GET['centro_id'];

$query = "INSERT INTO favoritos (user_id, centro_salud_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $userId, $centroId);
$result = $stmt->execute();

echo json_encode(['success' => $result]);
?>