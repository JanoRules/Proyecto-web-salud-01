<?php
require 'conexion.php'; // Asegúrate de que esta ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $centro_salud = $_POST['centro_salud'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Verifica si la conexión es válida
    if (!$conexion) {
        die("Error: No se pudo establecer la conexión a la base de datos.");
    }

    // Asegúrate de que el ID del centro de salud no sea NULL
    if (empty($centro_salud)) {
        die("Error: Debes seleccionar un centro de salud.");
    }

    // Consulta SQL para insertar la reseña
    $query = "INSERT INTO reseñas (nombre, centro_salud_id, calificacion, reseña) VALUES (?, ?, ?, ?)";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    // Verifica si la preparación fue exitosa
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->errorInfo()[2]);
    }

    // Ejecutar la consulta con los parámetros
    $stmt->execute([$name, $centro_salud, $rating, $review]);

    // Verifica si la ejecución fue exitosa
    if ($stmt->rowCount()) {
        header("Location: quick-salud.html");
        exit; // Asegúrate de que el script se detenga después de la redirección
    } else {
        echo "Error al guardar la reseña.";
    }

    // Cerrar la declaración
    $stmt->closeCursor();
}

// Cerrar la conexión
$conexion = null;
?>
