<?php
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['name'];
    $producto = $_POST['product'];
    $calificacion = $_POST['rating'];
    $reseña = $_POST['review'];

    // Insertar datos en la tabla 'reseñas'
    $sql_reseña = "INSERT INTO reseñas (nombre, producto, calificacion, reseña)
                   VALUES ('$nombre', '$producto', '$calificacion', '$reseña')";

    if ($conn->query($sql_reseña) === TRUE) {
        echo "<div style='text-align: center; margin-top: 50px;'>";
        echo "<p style='color: green; font-size: 18px;'>¡Reseña enviada exitosamente!</p>";
        echo "<a href='Reseña.html'>
                <button style='padding: 15px 30px; font-size: 18px; background-color: #007bff; color: white; border: none; border-radius: 8px; cursor: pointer;'>Volver a Reseñas</button>
              </a>";
        echo "</div>";
    } else {
        echo "Error al guardar la reseña: " . $conn->error;
    }

    $conn->close();
}
?>
