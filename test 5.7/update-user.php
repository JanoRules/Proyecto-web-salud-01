<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login2.html"); // Redirigir a login si no hay sesión
    exit();
}

$username = $_SESSION['username'];

// Consultar datos del usuario
$sql = "SELECT r.rut, r.nombre, r.apellidos, r.correo, r.fechaNacimiento, r.ubicacion FROM registro r
        JOIN login l ON r.rut = l.rut WHERE l.username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No se encontraron datos del usuario.";
    exit();
}

// Actualizar los datos del usuario si el formulario es enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $ubicacion = $_POST['ubicacion'];

    $sql_update = "UPDATE registro SET nombre='$nombre', apellidos='$apellidos', correo='$correo', fechaNacimiento='$fechaNacimiento', ubicacion='$ubicacion'
                   WHERE rut='$rut'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: update-user.html?success=true"); // Redirigir a la página con un mensaje de éxito
        exit();
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

$conn->close();
?>
