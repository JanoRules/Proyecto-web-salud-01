<?php
session_start(); // Asegúrate de iniciar la sesión para manejar el usuario
require 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $centro_salud_id = $_POST['centro_salud_id'];
    $user_id = $_SESSION['user_id']; // Asumiendo que tienes el ID del usuario en la sesión

    // Consulta SQL para insertar en favoritos
    $query = "INSERT INTO favoritos (user_id, centro_salud_id) VALUES (?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ii", $user_id, $centro_salud_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "No autorizado."]);
}
?>
