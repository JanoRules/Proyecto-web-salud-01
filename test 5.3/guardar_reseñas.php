<?php
include 'conexion.php'; // Conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $producto = htmlspecialchars($_POST['producto']);
    $calificacion = (int)$_POST['calificacion'];
    $reseña = htmlspecialchars($_POST['reseña']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO reseñas (nombre, producto, calificacion, reseña) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $nombre, $producto, $calificacion, $reseña);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Reseña guardada con éxito.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
