<?php
// Reportar todos los errores y mostrarlos
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taller_integracion_1";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$usuario = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$fechaNacimiento = $_POST['fechaNacimiento'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? '';
$correo = $_POST['correo'] ?? '';
$rut = $_POST['rut'] ?? '';

// Verificar que los campos obligatorios no estén vacíos antes de continuar
if (!empty($usuario) && !empty($password) && !empty($correo)) {
    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Usar PASSWORD_BCRYPT

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO usuarios (nombre, apellidos, username, password, fechaNacimiento, ubicacion, correo, rut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la sentencia fue exitosa
    if ($stmt === false) {
        die("Error al preparar la sentencia: " . $conn->error);
    }

    // Vincular los parámetros
    $stmt->bind_param('ssssssss', $nombre, $apellidos, $usuario, $hashed_password, $fechaNacimiento, $ubicacion, $correo, $rut);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Registro completado con éxito. Redirigiendo al login...";
        // Redirigir al login después de 3 segundos
        header("Refresh: 3; url=login2.html");
        exit();
    } else {
        echo "Error en el registro: " . $stmt->error; // Mostrar error si falla
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Por favor, complete todos los campos obligatorios.";
}
?>
