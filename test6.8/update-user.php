<?php
include 'conexion.php';
session_start();
echo "<link rel='stylesheet' href='register.css'>";

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    die("Error: No has iniciado sesión.");
}

$rut = $_SESSION['rut']; // Aquí obtienes el RUT del usuario

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];

    // Consulta SQL para actualizar los datos del usuario
    $sql = "UPDATE registro SET nombre=?, correo=?, ubicacion=? WHERE rut=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error al preparar la consulta: ' . $conn->error);
    }

    $stmt->bind_param("ssss", $nombre, $email, $direccion, $rut);

    if ($stmt->execute()) {
        echo "<div style='text-align: center; margin-top: 50px;'>";
        echo "<p style='color: green; font-size: 18px;'>Actualización de datos exitosa!.</p>";
        // Aquí agregamos el botón estilizado para redirigir a dashboard.html
        echo "<a href='dashboard.html'>
                    <button style='padding: 15px 30px; font-size: 18px; background-color: #007bff; color: white; border: none; border-radius: 8px; cursor: pointer;'>Volver</button>
                  </a>";
        echo "</div>";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>